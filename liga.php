<?php
require_once "funcoes.php";
require "nav.php";

loginLiga($userName, $liga);

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>[WEB 1] Exemplo Sistema de Login - Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<h1>Entrar numa liga</h1>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form action="liga.php" method="post">
  
<p>
    Quer cadastrar uma <a href="register.php">liga</a> ?.
  </p>

<p> Fazer login na liga de interesse </p>
<div id="Liga">
        <div id="tem">
        <label for="loginliga">Nome da liga </label>
            <input type="text" name="loginliga" id="loginliga">
            <br>
        <label for="codliga">Código da liga </label>
            <input type="password" name="codliga" id="codliga">
            <br>
        </div>
    </div>
 
  <input type="submit" name="submit" value="Criar usuário">
</form>

<ul>
  <li><a href="index.php">Voltar</a></li>
</ul>
</p>

</body>
</html>
