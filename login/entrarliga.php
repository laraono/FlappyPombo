<?php 
    require "funcoes.php";
    loginLiga($userName, $liga);

?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Entrar numa liga</title>
    </head>
    <body>
        <h1>Entrar numa liga</h1>
        <?php if($liga==NULL): ?>
        <form method="post" action="entrarliga.php">
            <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" required/>
            <br/>

            <label for="password">Senha: </label>
            <input type="password" id="password" name="password" required/>
            <br/>

            <input type="submit" id="submit" value="Enviar">
        </form>
        <?php else:
            echo "voce já tem uma liga";
        endif;
        ?>
    </body>
</html>