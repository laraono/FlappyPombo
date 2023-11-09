<?php

    require_once "db_functions.php";
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
        $liga = "";
    }

    $error = false;
    $success = false;
    $error_msg = "";

    function login($player) {
        global $error, $error_msg, $success;  
        $password = "";
          
        if ($player==NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["name"]) && isset($_POST["password"])) {
                $conn = connect_db();
                $user_name = mysqli_real_escape_string($conn,$_POST["name"]);
                $password = mysqli_real_escape_string($conn,$_POST["password"]);
                //$password = md5($password);

                $sql = "SELECT apelido, senha FROM usuario WHERE apelido = '$user_name';";
    
                $result = mysqli_query($conn, $sql);
                if($result) {
                    if (mysqli_num_rows($result) > 0) {
                        $user = mysqli_fetch_assoc($result);

                        if($user["apelido"]!=NULL) {
                            if ($user["senha"] == $password) {
                                $sql2 = "SELECT nomel FROM Participantes WHERE apelidou = '$user_name';";
                        $query = mysqli_query($conn, $sql2);
        
                        if($query){
                            if (mysqli_num_rows($query) > 0) {
                                $nomeLiga = mysqli_fetch_assoc($query);
                                $_SESSION["liga"] = $nomeLiga["nomel"];
                            }
                        } 
                                $success=true;
                                $_SESSION["user_name"] = $user["apelido"];
                                header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
                                exit();
                            } else {
                                $error_msg = "Senha incorreta!";
                                $error = true;
                            }
                        } else {
                            $error_msg = "Você não é cadastrado";
                            $error = true;
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

    function loginLiga($player, $league) {
        global $error, $error_msg, $success;

        if($league==NULL && $_SERVER["REQUEST_METHOD"] == "POST"){
            if ($_POST["nomeliga"]!=NULL) {
                if($player!=NULL) {

                    $conn = connect_db();  
                    
                    $nomeLiga = mysqli_real_escape_string($conn,$_POST["nomeliga"]);
                    $password = mysqli_real_escape_string($conn,$_POST["codliga"]);
                    //$password = md5($password);

                    $sql = "SELECT senha FROM liga WHERE nome = '$nomeLiga';";
                    $result = mysqli_query($conn, $sql);

                    if($result){
                        if (mysqli_num_rows($result) > 0) {
                            $senhaLiga = mysqli_fetch_assoc($result);
                            $check = $senhaLiga["senha"];
                            echo "ola";

                            if($password==$check) {
                                echo "oi";
                                $sql = "INSERT INTO participantes (apelidou, nomel) VALUES ('$player', '$nomeLiga');";
                
                                if(mysqli_query($conn, $sql)){
                                    $success = true;
                                    $error = false;
                                    $_SESSION["liga"] = $nomeLiga;
                                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
                                } else {
                                    $error_msg = mysqli_error($conn);
                                    $error = true;
                                }
                
                            } else {
                                $error_msg = "Senha incorreta.";
                                $error=true;
                            }
                        }
                    } else {
                        $error_msg = mysqli_error($conn);
                        $error = true;
                    }
                } else {
                    $error_msg = "Você não está logado.";
                }
                
            } 
        } 
    }

    function cadastroLiga($player, $league) {
        global $error, $error_msg, $success;
        if($league==NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
            if ($player!=NULL) {
                $conn = connect_db();  

                $nomeLiga = mysqli_real_escape_string($conn,$_POST["nomeliga"]);
                $password = mysqli_real_escape_string($conn,$_POST["codliga"]);
               // $check = mysqli_real_escape_string($conn,$_POST["check"]);
                
              //  if($password==$check) {
                  //  $password = md5($password);

                    $sql = "INSERT INTO liga (nome, senha) VALUES ('$nomeLiga', '$password');";

                    if(mysqli_query($conn, $sql)){
                        $success = true;
                        $error = false;
                        header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/liga.php");
                    }
                    else {
                        $error_msg = mysqli_error($conn);
                        $error = true;
                    }

              /*  } else {
                    $error_msg = "Senha não confere com a confirmação.";
                    $error=true;
                } */        
            } else {
                $error_msg = "Você não está logado";
            }
        } else {
            $error_msg = "Você já possui uma liga.";
        }
    }

    function cadastroUsuario($player) {
        global $error, $error_msg, $success;
        if ($player==NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = connect_db();  

            $name = mysqli_real_escape_string($conn,$_POST["name"]);
            $password = mysqli_real_escape_string($conn,$_POST["password"]);
            $check = mysqli_real_escape_string($conn,$_POST["confirm_password"]);
            
            if($password==$check) {
                //$password = md5($password);

                $sql = "INSERT INTO usuario (apelido, senha, pontos, pontot, highScore) VALUES ('$name', '$password', 0, 0, 0);";

                if(mysqli_query($conn, $sql)){
                    $success = true;
                    $error = false;
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

    function sairLiga($player, $league) {
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
            $sql = "SELECT * FROM Partida WHERE apelidou='$player' ORDER BY data, hora;";
            
            $result=mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "Data: " . $row["data"]. " - Pontuação: " . $row["pontuacao"]. " - Tempo Jogado: " . $row["tempoj"]. "<br>";
                }
            } else {
                $error_msg = mysqli_error($conn);
                $error = true;
            }                         
            
        } else {
            $error_msg = "Você não está logado";
        }
    }
    
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
                $sql = "SELECT apelido, pontos FROM usuario ORDER BY pontos DESC;";
                
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

    function rankingGeral($player, $league) {
        if($player!=NULL) {
            if($league!=NULL) {
                $conn = connect_db();                 
                $sql = "SELECT apelido, pontot, nomel FROM Usuario INNER JOIN Participantes ON Usuario.apelido = Participantes.apelidou ORDER BY pontot DESC;";
                
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
                $sql = "SELECT apelido, pontot FROM usuario ORDER BY pontot DESC;";
                
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

    function rankingHighScore($player, $league) {
        if($player!=NULL) {
            if($league!=NULL) {
                $conn = connect_db();                 
                $sql = "SELECT apelido, highScore, nomel FROM Usuario INNER JOIN Participantes ON Usuario.apelido = Participantes.apelidou ORDER BY highScore DESC, apelido ASC;";
                
                $result=mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    echo "Jogador: " . $row["apelido"]. " - Pontuação: " . $row["highScore"]. " - Liga: " . $row["nomel"]. "<br>";
                    }
                } else {
                    $error_msg = mysqli_error($conn);
                    $error = true;
                }       
            } else {
                $conn = connect_db();                 
                $sql = "SELECT apelido, highScore FROM usuario ORDER BY highScore DESC, apelido ASC;";
                
                $result=mysqli_query($conn, $sql);
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                    echo "Jogador: " . $row["apelido"]. " - Pontuação: " . $row["highScore"]. "<br>";
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

    function insertPontos($player, $ponto, $recorde) {
        if($player!=NULL) {
            $conn = connect_db();  

            $sql = "SELECT highScore FROM usuario WHERE apelido='$player';";
            $result = mysqli_query($conn, $sql);
            $row = $result->fetch_assoc();
            if($recorde > $row["highScore"]) {
                $sql = "UPDATE usuario set pontot='$ponto'+pontot, pontos='$ponto'+pontos, highScore = '$recorde' WHERE apelido='$player';"; 
            } else {
                $sql = "UPDATE usuario set pontot='$ponto'+pontot, pontos='$ponto'+pontos WHERE apelido='$player';"; 
            }

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

    function inserirPartida($player, $ponto, $tempo) {
        if($player!=NULL) {
            date_default_timezone_set('America/Sao_Paulo');
            $conn = connect_db(); 
            $dia = date("Y-m-d");
            $hora = date("H:i");  
            
            $minutes = round($tempo/60);
            $seconds = $tempo % 60;

            if($seconds < 10) {
                $tempo = $minutes . ":" .  "0" . $seconds;
            } else {
                $tempo = $minutes . ":" .  $seconds;
            }

            $sql = "INSERT INTO partida(data, hora, pontuacao, tempoj, apelidou) VALUES('$dia', '$hora', '$ponto', '$tempo', '$player');";
            
            if (mysqli_query($conn, $sql)) {
                
            } else {
                $error_msg = mysqli_error($conn);
                $error = true;
            }       
            
        } else {
            $error_msg = "Você não está logado";
        }
    }

    
?>        