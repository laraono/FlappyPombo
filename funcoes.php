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

        //confere se o usuário já está logado
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

                        //confere se foi encontrado um usuario com mesmo nome enviado
                        if($user["apelido"]!=NULL) { 
                            if ($user["senha"] == $password) { 

                                //ve se o usuario já possui liga
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
                        $error_msg = "Você não é cadastrado";
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

        //confere se o usuario já possui uma liga
        if($league==NULL && $_SERVER["REQUEST_METHOD"] == "POST"){
            if ($_POST["nomeliga"]!=NULL) {
                
                //confere se o usuario esta logado
                if($player!=NULL) {

                    $conn = connect_db();

                    $nomeLiga = mysqli_real_escape_string($conn,$_POST["nomeliga"]);
                    $password = mysqli_real_escape_string($conn,$_POST["codliga"]);
                    //$password = md5($password);

                    $sql = "SELECT senha FROM liga WHERE nome = '$nomeLiga';";
                    $result = mysqli_query($conn, $sql);

                    //confere se a liga existe
                    if($result) {
                        if (mysqli_num_rows($result) > 0) {
                            $senhaLiga = mysqli_fetch_assoc($result);
                            $check = $senhaLiga["senha"];

                            if($password==$check) {
                                $sql = "INSERT INTO participantes (apelidou, nomel, pontot) VALUES ('$player', '$nomeLiga', 0);";

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
                        } else {
                            $error = true;
                            $error_msg = "A liga não existe";
                        }
                    } else {
                        $error_msg = mysqli_error($conn);
                        $error = true;
                    }
                } else {
                    $error = true;
                    $error_msg = "Você não está logado.";
                }

            }
        }
    }

    function cadastroLiga($player, $league) {
        global $error, $error_msg, $success;

        //confere se o usuario já possui uma liga
        if($league==NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["nomeliga"])) {

                //confere se o usuario já esta logado
                if ($player!=NULL) {
                    $conn = connect_db();

                    $nomeLiga = mysqli_real_escape_string($conn,$_POST["nomeliga"]);
                    $password = mysqli_real_escape_string($conn,$_POST["codliga"]);
               
                    $sql = "SELECT nome FROM liga WHERE nome = '$nomeLiga';";
                    $result = mysqli_query($conn, $sql);

                    //confere se não existe uma liga com o mesmo nome
                    if (!mysqli_num_rows($result)) {
                        date_default_timezone_set('America/Sao_Paulo');
                        $conn = connect_db();
                        $dia = date("Y-m-d");

                        $sql = "INSERT INTO liga(senha, nome, datal) VALUES('$password', '$nomeLiga', '$data');";

                        if(mysqli_query($conn, $sql)){
                            $success = true;
                            $error = false;
                            loginLiga($player,$league);
                        }
                        else {
                            $error_msg = mysqli_error($conn);
                            $error = true;
                        }
                    } else {
                        $error = true;
                        $error_msg = "Liga já existe";
                    }
                
                } else {
                    $error = true;
                    $error_msg = "Você não está logado";
                }
            }
        } else {
            $error = true;
            $error_msg = "Você já possui uma liga.";
        }
    }

    function cadastroUsuario($player) {
        global $error, $error_msg, $success;

        //confere se o usuário já está logado
        if ($player == NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = connect_db();

            $name = mysqli_real_escape_string($conn, $_POST["name"]);
            $password = mysqli_real_escape_string($conn, $_POST["password"]);
            $check = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

            if ($password == $check) {

                //confere se houve um upload de uma imagem
                if(is_uploaded_file($_FILES["profile_image"]["tmp_name"])) { 
                    // Processar upload da imagem
                    $targetDirectory = "fotos_perfil/";  // Diretório onde as imagens serão armazenadas
                    $targetFile = $targetDirectory . $name . ".jpg"; // Nome do arquivo será o nome de usuário com extensão jpg
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                
                    // Verificar se o arquivo é uma imagem real
                    if (isset($_POST["submit"])) {
                        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
                        if ($check !== false) {
                            $uploadOk = 1;
                        } else {
                            $error_msg = "O arquivo não é uma imagem.";
                            $uploadOk = 0;
                        }
                    }

                    // Verificar o tamanho da imagem (limite de 5 MB)
                    if ($_FILES["profile_image"]["size"] > 5000000) {
                        $error_msg = "Desculpe, a imagem é muito grande (limite de 5 MB).";
                        $uploadOk = 0;
                    }

                    // Permitir apenas alguns formatos de arquivo
                    $allowedFormats = array("jpg", "jpeg", "png", "gif");
                    if (!in_array($imageFileType, $allowedFormats)) {
                        $error_msg = "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
                        $uploadOk = 0;
                    }

                    // Se houver erros no upload, exibir mensagem de erro
                    if ($uploadOk == 0) {
                        $error = true;
                    } else {
                        // Se tudo estiver correto, tentar fazer o upload
                        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                            // Atualizar o caminho da imagem na tabela do banco de dados
                            $imagePath = $targetFile;
                            $sql = "INSERT INTO usuario (apelido, senha, pontos, pontot, highScore, profile_image) VALUES ('$name', '$password', 0, 0, 0, '$imagePath');";

                            if (mysqli_query($conn, $sql)) {
                                $success = true;
                                $error = false;
                            } else {
                                $error_msg = mysqli_error($conn);
                                $error = true;
                            }
                        } else {
                            $error_msg = "Desculpe, ocorreu um erro no upload da imagem.";
                            $error = true;
                        }
                    }
                } else {
                    $sql = "INSERT INTO usuario (apelido, senha, pontos, pontot, highScore) VALUES ('$name', '$password', 0, 0, 0);";

                            if (mysqli_query($conn, $sql)) {
                                $success = true;
                                $error = false;
                            } else {
                                $error_msg = mysqli_error($conn);
                                $error = true;
                            }
                }
            } else {
                $error_msg = "Senha não confere com a confirmação.";
                $error = true;
            }
        } else {
            $error = true;
            $error_msg = "Você já está logado.";
        }
    }

    function sairLiga($player, $league) {
        //confere se o usuario esta logado
        if($player!=NULL) {
            if ($league!=NULL) {
                $conn = connect_db();
                $sql = "DELETE FROM Participantes WHERE apelidou='$player' AND nomel='$league';";

                if(mysqli_query($conn, $sql)) {
                    $success = true;
                    $_SESSION["liga"] = "";
                    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
                } else {
                    $error_msg = mysqli_error($conn);
                    echo $error_msg;
                }
            } 
        } 
    }

    function historicoPartidas($player, $showProfileImage = false) {
        if ($player != NULL) {
            $conn = connect_db();
            $sql = "SELECT p.*, u.profile_image FROM Partida p
                    JOIN Usuario u ON p.apelidou = u.apelido
                    WHERE p.apelidou='$player' ORDER BY p.datap, p.hora;";

            $result = mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                echo "<table class=\"my-5 mx-auto col-6\">";
                echo "<tr> <th> Data </th> <th> Hora </th> <th> Pontuação </th> <th> Tempo de jogo</th></tr>";
                while ($row = $result->fetch_assoc()) {
                    //mudança do formato de tempo e data para ficar mais fácil a visualização
                    $data = date("d/m/Y", strtotime($row["datap"]));
                    $hora = date("H:i", strtotime($row["hora"]));
                    $tempoj = date("H:i", strtotime($row["tempoj"]));

                    echo "<tr>";
                    echo "<td>" . $data . "</td>";
                    echo "<td>" . $hora . "</td>";
                    echo "<td>" . $row["pontuacao"] . "</td>";
                    echo "<td>" . $tempoj . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } 
        } 
    }

    function getProfileImagePath($player) {
        $conn = connect_db();
        $sql = "SELECT profile_image FROM usuario WHERE apelido='$player';";

        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['profile_image'];
        }
    }

    function rankingSemanal($league) {
        //ve que tipo de ranking sera mostrado, se o da liga ou o geral
        if($league!=NULL) {
            $conn = connect_db();
            $sql = "SELECT apelido, pontos, nomel FROM usuario INNER JOIN participantes ON (usuario.apelido = participantes.apelidou) WHERE nomel='$league' ORDER BY pontos DESC, apelido ASC;";

            $result=mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                echo "<table class=\"my-5 mx-auto col-12\">";
                echo "<tr class=\"ranking\"> <th></th><th> Jogador</th> <th>Pontuação </th> <th>Liga</th> <th></th></tr>";
                $count = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$count."</td>";
                    echo "<td>". $row["apelido"]."</td>";
                    echo "<td>".$row["pontos"]. " </td>";
                    echo "<td>".$row["nomel"]. " </td>";
                    if (getProfileImagePath($row["apelido"])) {
                        echo "<td>";
                        $profileImagePath = getProfileImagePath($row["apelido"]); // Substitua pela função correta para obter o caminho da imagem
                        
                    }
                    else {
                        $profileImagePath = "fotos_perfil/defalt.png"; // Substitua pela função 
                    }
                    echo "<td><img src=\"$profileImagePath\" class=\"rounded-circle\" alt=\"Imagem de Perfil\" style=\"width:50px;height:50px;\"></td>";
                        echo "</td>";
                    echo "</tr>";

                    $count++;
                }
                echo "</table>";
            } 
        } else {
            $conn = connect_db();
            $sql = "SELECT apelido, pontos FROM usuario ORDER BY pontos DESC, apelido ASC;";

            $result=mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                echo "<table class=\"my-5 mx-auto col-12\">";
                echo "<tr><th></th> <th> Jogador</th> <th>Pontuação</th> </tr>";
                $count = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$count."</td>";
                    echo "<td>". $row["apelido"]."</td>";
                    echo "<td>".$row["pontos"]. " </td>";
                    if (getProfileImagePath($row["apelido"])) {
                        echo "<td>";
                        $profileImagePath = getProfileImagePath($row["apelido"]); // Substitua pela função correta para obter o caminho da imagem
                        
                    }
                    else {
                        $profileImagePath = "fotos_perfil/defalt.png"; // Substitua pela função 
                    }
                    echo "<td><img src=\"$profileImagePath\" class=\"rounded-circle\" alt=\"Imagem de Perfil\" style=\"width:50px;height:50px;\"></td>";
                        echo "</td>";
                    echo "</tr>";
                    $count++;
                }
                echo "</table>";
            }
        }
    }

    function rankingGeral($league) {
        //ve que tipo de ranking sera mostrado, se o da liga ou o geral
        if($league!=NULL) {
            $conn = connect_db();
            $sql = "SELECT apelido, participantes.pontot, nomel FROM usuario INNER JOIN participantes ON (usuario.apelido = participantes.apelidou) WHERE nomel='$league' ORDER BY participantes.pontot DESC, apelido ASC;";

            $result=mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                echo "<table class=\"my-5 mx-auto col-12\">";
                echo "<tr class=\"ranking\"> <th></th><th>Jogador</th> <th>Pontuação </th> <th>Liga</th><th></th> </tr>";
                $count = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$count."</td>";
                    echo "<td>". $row["apelido"]."</td>";
                    echo "<td>".$row["pontot"]. " </td>";
                    echo "<td>".$row["nomel"]. " </td>";
                    if (getProfileImagePath($row["apelido"])) {
                        echo "<td>";
                        $profileImagePath = getProfileImagePath($row["apelido"]); // Substitua pela função correta para obter o caminho da imagem
                        
                    }
                    else {
                        $profileImagePath = "fotos_perfil/defalt.png"; // Substitua pela função 
                    }
                    echo "<td><img src=\"$profileImagePath\" class=\"rounded-circle\" alt=\"Imagem de Perfil\" style=\"width:50px;height:50px;\"></td>";
                        echo "</td>";
                    echo "</tr>";
                    $count++;
                }
                echo "</table>";
            }
        } else {
            $conn = connect_db();
            $sql = "SELECT apelido, pontot FROM usuario ORDER BY pontot DESC, apelido ASC;";

            $result=mysqli_query($conn, $sql);
            if ($result->num_rows > 0) {
                echo "<table class=\"my-5 mx-auto col-12\">";
                echo "<tr><th></th> <th> Jogador</th> <th>Pontuação </th> </tr>";
                $count = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$count."</td>";
                    echo "<td>". $row["apelido"]."</td>";
                    echo "<td>".$row["pontot"]. " </td>";
                    if (getProfileImagePath($row["apelido"])) {
                        echo "<td>";
                        $profileImagePath = getProfileImagePath($row["apelido"]); // Substitua pela função correta para obter o caminho da imagem
                        
                    }
                    else {
                        $profileImagePath = "fotos_perfil/defalt.png"; // Substitua pela função 
                    }
                    echo "<td><img src=\"$profileImagePath\" class=\"rounded-circle\" alt=\"Imagem de Perfil\" style=\"width:50px;height:50px;\"></td>";
                        echo "</td>";
                    echo "</tr>";
                    $count++;
                }
                echo "</table>";
            } 
        }
    }

    function insertPontos($player, $ponto, $league) {
        //confere se o usuario esta logado
        if($player!=NULL) {
            $conn = connect_db();

            $sql = "SELECT highScore FROM usuario WHERE apelido='$player';";
            $result = mysqli_query($conn, $sql);
            $row = $result->fetch_assoc();
            //confere se a pontuacao é maior que o highscore
            if($ponto > $row["highScore"]) {
                $sql = "UPDATE usuario SET pontot='$ponto'+pontot, pontos='$ponto'+pontos, highScore = '$ponto' WHERE apelido='$player';";
            } else {
                $sql = "UPDATE usuario SET pontot='$ponto'+pontot, pontos='$ponto'+pontos WHERE apelido='$player';";
            }

            mysqli_query($conn, $sql);

            if($league!=NULL) {
                $query = "UPDATE participantes SET pontot= pontot +'$ponto' WHERE nomel='$league' AND apelidou='$player';";
                mysqli_query($conn, $query);
            }
        } 
    }

    function editUsuario($player)  {
        global $error, $error_msg, $success;

        //confere se o usuário já está logado
        if ($player != NULL && $_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = connect_db();

            $sql = "SELECT * FROM usuario WHERE apelido = '$player';";
            $query = mysqli_query($conn, $sql);
            $row = $query->fetch_assoc();

            $password = mysqli_real_escape_string($conn, $_POST["password"]);
            
            //confere a senha do usuário antes de alterar qualquer dado
            if($password == $row["senha"]) {

                $newPassword = mysqli_real_escape_string($conn, $_POST["new-password"]);
                $check = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

                if($newPassword == "") { 
                    $newPassword = $row["senha"];
                    $check = $row["senha"];
                }

                if ($newPassword == $check) {

                    //confere se houve um upload de uma imagem
                    if(is_uploaded_file($_FILES["profile_image"]["tmp_name"])) {

                        // Processar upload da imagem
                        $targetDirectory = "fotos_perfil/";  // Diretório onde as imagens serão armazenadas
                        $targetFile = $targetDirectory . $player . ".jpg"; // Nome do arquivo será o nome de usuário com extensão jpg

                        
                        //deletar a imagem existente
                        if(file_exists($targetFile)) {
                            $file_to_delete = $targetFile;
                            unlink($file_to_delete);
                        }

                        $uploadOk = 1;
                        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

                    
                        // Verificar se o arquivo é uma imagem real
                        if (isset($_POST["submit"])) {
                            $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
                            if ($check !== false) {
                                $uploadOk = 1;
                            } else {
                                $error_msg = "O arquivo não é uma imagem.";
                                $uploadOk = 0;
                            }
                        }

                        // Verificar o tamanho da imagem (limite de 5 MB)
                        if ($_FILES["profile_image"]["size"] > 5000000) {
                            $error_msg = "Desculpe, a imagem é muito grande (limite de 5 MB).";
                            $uploadOk = 0;
                        }

                        // Permitir apenas alguns formatos de arquivo
                        $allowedFormats = array("jpg", "jpeg", "png", "gif");
                        if (!in_array($imageFileType, $allowedFormats)) {
                            $error_msg = "Desculpe, apenas arquivos JPG, JPEG, PNG e GIF são permitidos.";
                            $uploadOk = 0;
                        }

                        // Se houver erros no upload, exibir mensagem de erro
                        if ($uploadOk == 0) {
                            $error = true;
                        } else {
                            // Se tudo estiver correto, tentar fazer o upload
                            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFile)) {
                                // Atualizar o caminho da imagem na tabela do banco de dados
                                $imagePath = $targetFile;
                                $sql = "UPDATE usuario SET senha='$newPassword',  profile_image ='$imagePath' WHERE apelido = '$player';";

                                if (mysqli_query($conn, $sql)) {
                                    $success = true;
                                    $error = false;
                                } else {
                                    $error_msg = mysqli_error($conn);
                                    $error = true;
                                }
                            } else {
                                $error_msg = "Desculpe, ocorreu um erro no upload da imagem.";
                                $error = true;
                            }
                        }
                    } else {
                        $sql = "UPDATE usuario SET senha='$newPassword' WHERE apelido = '$player';";

                                if (mysqli_query($conn, $sql)) {
                                    $success = true;
                                    $error = false;
                                } else {
                                    $error_msg = mysqli_error($conn);
                                    $error = true;
                                }
                    }
                } else {
                    $error_msg = "Senha não confere com a confirmação.";
                    $error = true;
                }
            } else {
                $error = true;
                $error_msg = "Senha incorreta";
            }
        } else {
            $error = true;
            $error_msg = "Você não está logado.";
        }
    }

    function zerarPontuacaoSemanal() {
        date_default_timezone_set('America/Sao_Paulo');
        $conn = connect_db();
        $dia = date("D");
        $cookieName = "semanal";

        //confere o dia da semana
        if($dia=="Sun") {
            if(isset($_COOKIE[$cookieName]) ) {
                //confere o valor do cookie para nao zerar a pontuacao mais de uma vez
                if($_COOKIE[$cookieName]==0) {
                    $sql = "UPDATE usuario set pontos=0;";
        
                    if (mysqli_query($conn, $sql)) {
                        //muda o valor do cookie para a pontuacao nao zerar mais de uma vez
                        setcookie($cookieName, 1, time() + 86400 * 6, "/");  
                    } 
                }
            }  
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

            $sql = "INSERT INTO partida(datap, hora, pontuacao, tempoj, apelidou) VALUES('$dia', '$hora', '$ponto', '$tempo', '$player');";

            if (mysqli_query($conn, $sql));
            
        } 
    }

    zerarPontuacaoSemanal();

    if(isset($_POST["ponto"])) {
        insertPontos($userName, $_POST["ponto"], $liga);
    }

    if(isset($_POST["ponto"]) && isset($_POST["tempo"])) {
        inserirPartida($userName, $_POST["ponto"], $_POST["tempo"]);
    }

?>
