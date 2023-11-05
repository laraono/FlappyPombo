<?php 
    require "funcoes.php";
    cadastroLiga($userName, $liga);
?>

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro Liga</title>
    </head>
    <body>
        <h1>Cadastro Liga</h1>
        <?php if($liga==NULL): ?>
        <form method="post" action="cadastroLiga.php">
        <label for="nome">Nome: </label>
            <input type="text" id="nome" name="nome" required/>
            <br/>

            <label for="password">Senha: </label>
            <input type="password" id="password" name="password" required/>
            <br/>

            <label for="check">Confirmação de Senha: </label>
            <input type="password" id="check" name="check" required>
            <br/>

            <input type="submit" id="submit">
        </form>
        <?php else:
            echo "Você já tem uma liga";
        endif;
        ?>
    </body>
</html>