<?php 
    require "funcoes.php";
   login($userName);
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <?php if($userName==NULL):?>
        <form method="post" action="login.php">
            <label for="name">Nome: </label>
            <input type="text" id="nome" name="name" required/>
            <br/>

            <label for="password">Senha: </label>
            <input type="password" id="password" name="password" required/>
            <br/>

            <input type="submit" id="submit" value="Enviar">
        </form>
        <a id="signup" href="cadastro.php"> Cadastro </a>
        <?php else: ?>
        <p> Já está logado <p>
        <?php endif; ?>
    </body>
</html>




