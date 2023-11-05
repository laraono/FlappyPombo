<?php
    session_start();

    if (isset($_SESSION["user_name"])) {
        $userName = $_SESSION["user_name"];

        if(isset($_SESSION["liga"])) {
            $liga = $_SESSION["liga"];
        } else {
            $liga = "";
        }
    } else{
        $userName = "";
    }

    function connect_db() {
        global $servername, $username, $db_password, $dbname;

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "flappy_bird";

        $conn = mysqli_connect($servername, $username, $password,$dbname);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

    
        return($conn);
    }

    function login($player) {
        $error = false;
        $password = "";
          
        if ($player==NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["name"]) && isset($_POST["password"])) {
                $conn = connect_db();
                $user_name = mysqli_real_escape_string($conn,$_POST["name"]);
                $password = mysqli_real_escape_string($conn,$_POST["password"]);
                $password = md5($password);
    
                $sql = "SELECT apelido, senha FROM usuario
                        WHERE apelido = '$user_name';";
    
                $result = mysqli_query($conn, $sql);
                if($result){
                    echo "resultado <br>";
                    if (mysqli_num_rows($result) > 0) {
                        $user = mysqli_fetch_assoc($result);
                        echo $user["apelido"];
    
                        if ($user["senha"] == $password) {
                            $_SESSION["user_name"] = $user["apelido"];
                            header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/paginaInicial.php");
                            exit();
                        } else {
                            $error_msg = "Senha incorreta!";
                            $error = true;
                        }
                    } else {
                        $error_msg = mysqli_error($conn);
                        $error = true;
                    }
    
                    $sql = "SELECT nomel FROM participantes WHERE apelidou = '$user_name';";
                    $result = mysqli_query($conn, $sql);
    
                    if($result){
                        if (mysqli_num_rows($result) > 0) {
                            $nomeLiga = mysqli_fetch_assoc($result);
                            $_SESSION["liga"] = $nomeLiga["nomel"];
                        }
                    } else {
                        $error_msg = mysqli_error($conn);
                        $error = true;
                    }
                }
            } else {
                $error_msg = "Por favor, preencha todos os dados.";
                $error = true;
            }
        } 
    }

    function cadastroLiga($player, $league) {
        $error = false;
        $success = false;

        if($player!=NULL){
            if ($league==NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
                $conn = connect_db();  

                $nomeLiga = mysqli_real_escape_string($conn,$_POST["nome"]);
                $password = mysqli_real_escape_string($conn,$_POST["password"]);
                $check = mysqli_real_escape_string($conn,$_POST["check"]);
                
                if($password==$check) {
                    $password = md5($password);

                    $sql = "INSERT INTO liga (nome, senha) VALUES ('$nomeLiga', '$password');";

                    if(mysqli_query($conn, $sql)){
                        $success = true;
                        echo $nomeLiga;
                        header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/entrarliga.php");
                    }
                    else {
                        $error_msg = mysqli_error($conn);
                        $error = true;
                    }

                } else {
                    $error_msg = "Senha não confere com a confirmação.";
                    $error=true;
                }         
            } else {
                $error_msg = "Você já possui uma liga.";
            }
        } else {
            $error_msg = "Você não está logado";
        }
    }

    function cadastroUsuario($player) {
        $error = false;
        $success = false;

        if ($player==NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = connect_db();  

            $name = mysqli_real_escape_string($conn,$_POST["nome"]);
            $password = mysqli_real_escape_string($conn,$_POST["password"]);
            $check = mysqli_real_escape_string($conn,$_POST["check"]);
            
            if($password==$check) {
                $password = md5($password);

                $sql = "INSERT INTO usuario (apelido, senha) VALUES ('$name', '$password');";

                if(mysqli_query($conn, $sql)){
                    $success = true;
                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");
                } else {
                    $error_msg = mysqli_error($conn);
                    $error = true;
                }

            } else {
                $error_msg = "Senha não confere com a confirmação.";
                $error=true;
            }         
        } else {
            $error_msg = "Você já está logado.";
        }
    }

    function loginLiga($player, $league) {
        $error = false;
        $success = false;

        if($player!=NULL){
            if ($league==NULL && $_SERVER["REQUEST_METHOD"] == "POST") {

                $conn = connect_db();  

                $nomeLiga = mysqli_real_escape_string($conn,$_POST["nome"]);
                $password = mysqli_real_escape_string($conn,$_POST["password"]);
                $password = md5($password);

                $sql = "SELECT senha FROM liga WHERE nome = '$nomeLiga';";
                $result = mysqli_query($conn, $sql);

                if($result){
                    if (mysqli_num_rows($result) > 0) {
                        $senhaLiga = mysqli_fetch_assoc($result);
                        $check = $senhaLiga["senha"];

                        if($password==$check) {
                            $sql = "INSERT INTO participantes (apelidou, nomel) VALUES ('$userName', '$nomeLiga');";
            
                            if(mysqli_query($conn, $sql)){
                                $success = true;
                                $_SESSION["liga"] = $nomeLiga;
                                header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/paginaInicial.php");
                            } else {
                                $error_msg = mysqli_error($conn);
                                $error = true;
                            }
            
                        } else {
                            $error_msg = "Senha não confere com a confirmação.";
                            $error=true;
                        }
                    }
                } else {
                    $error_msg = mysqli_error($conn);
                    $error = true;
                }
                
            } else {
                $error_msg = "Você já possui uma liga.";
            }
        } else {
            $error_msg = "Você não está logado.";
        }
    }

    function sairLiga($player, $league) {
        $error = false;
        $success = false;

        if($player!=NULL) {
            if ($league!=NULL) {
                $conn = connect_db();                 
                $sql = "DELETE FROM participantes WHERE apelidou='$player' AND nomel='$league';";

                if(mysqli_query($conn, $sql)) {
                    $success = true;
                    $_SESSION["liga"] = "";
                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
                } else {
                    $error_msg = mysqli_error($conn);
                    $error = true;
                }                         
            } else {
                $error_msg = "Você não possui uma liga.";
            }
        } else {
            $error_msg = "Você não está logado";
        }
    }

    function historicoPartidas($player) {
        if($player!=NULL) {
            $conn = connect_db();                 
            $sql = "SELECT * FROM partidas WHERE apelidou='$player' ORDER BY datahora;";
            
            $result=mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "Data: " . $row["datahora"]. " - Pontuação: " . $row["pontuacao"]. " - Tempo Jogado: " . $row["tempojogo"]. "<br>";
                }
            } else {
                $error_msg = mysqli_error($conn);
                $error = true;
            }                         
            
        } else {
            $error_msg = "Você não está logado";
        }
    }
    
    //precisa ser modificado
    function rankingSemanal($player, $league) {
        if($player!=NULL) {
            if($league!=NULL) {
                $conn = connect_db();                 
                $sql = "SELECT apelido, pontos, nomel FROM usuario INNER JOIN participantes ON usuario.apelido = participantes.apelidou ORDER BY pontos DESC;";
                
                $result=mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    echo "Jogador: " . $row["apelido"]. " - Pontuação: " . $row["pontos"]. " - Liga: " . $row["nomel"]. "<br>";
                    }
                } else {
                    $error_msg = mysqli_error($conn);
                    $error = true;
                }       
            } else {
                $conn = connect_db();                 
                $sql = "SELECT apelido, pontos, nomel FROM usuario ORDER BY pontos DESC;";
                
                $result=mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    echo "Jogador: " . $row["apelido"]. " - Pontuação: " . $row["pontos"]. "<br>";
                    }
                } else {
                    $error_msg = mysqli_error($conn);
                    $error = true;
                }       
            }                 
            
        } else {
            $error_msg = "Você não está logado";
        }
    }

    //precisa ser modificado
    function rankingGeral($player, $league) {
        if($player!=NULL) {
            if($league!=NULL) {
                $conn = connect_db();                 
                $sql = "SELECT apelido, pontot, nomel FROM usuario INNER JOIN participantes ON usuario.apelido = participantes.apelidou ORDER BY pontos DESC;";
                
                $result=mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    echo "Jogador: " . $row["apelido"]. " - Pontuação: " . $row["pontot"]. " - Liga: " . $row["nomel"]. "<br>";
                    }
                } else {
                    $error_msg = mysqli_error($conn);
                    $error = true;
                }       
            } else {
                $conn = connect_db();                 
                $sql = "SELECT apelido, pontot, nomel FROM usuario ORDER BY pontos DESC;";
                
                $result=mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    echo "Jogador: " . $row["apelido"]. " - Pontuação: " . $row["pontot"]. "<br>";
                    }
                } else {
                    $error_msg = mysqli_error($conn);
                    $error = true;
                }       
            }                 
            
        } else {
            $error_msg = "Você não está logado";
        }
    }

    function insertPontos($player) {
        if($player!=NULL) {
            $conn = connect_db();     
            $ponto;            
            $sql = "UPDATE usuario set pontot+='$ponto', pontos+='$ponto' WHERE apelido='$player';";
            
            if (mysqli_query($conn, $sql)) {
                
            } else {
                $error_msg = mysqli_error($conn);
                $error = true;
            }       
            
        } else {
            $error_msg = "Você não está logado";
        }
    }

    function zerarPontuacaoSemanal() {
        date_default_timezone_set('America/Sao_Paulo');
        $conn = connect_db(); 
        $dia = date("D");
        $hora = date("H:i");
        
        if($dia=="Sat" && $hora=='23:59')
        $sql = "UPDATE usuario set pontos=0;";
        
        if (mysqli_query($conn, $sql)) {
            
        } else {
            $error_msg = mysqli_error($conn);
            $error = true;
        }       
    }


?>        