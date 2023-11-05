<?php 
    require "funcoes.php";
    cadastroUsuario($userName);
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro</title>
    </head>
    <body>
        <h1>Cadastro</h1>
        <form method="post" action="cadastro.php">
            <label for="name">Nome: </label>
            <input type="text" id="name" name="name" required/>
            <br/>

            <label for="password">Senha: </label>
            <input type="password" id="password" name="password" required/>
            <br/>

            <label for="check">Confirmação de Senha: </label>
            <input type="password" id="check" name="check" required>
            <br/>

            <input type="submit" id="submit" value="Enviar">
        </form>
    </body>
</html>