<?php
require_once "funcoes.php";
require "nav.php";
login($userName);
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>[WEB 1] Exemplo Sistema de Login - Registro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<h1>Login</h1>

<?php if($userName!=NULL): ?>
    <h3>Você já está logado!</h3>
  </body>
  </html>
  <?php exit(); ?>
<?php endif; ?>

<?php if ($error): ?>
  <h3 style="color:red;"><?php echo $error_msg; ?></h3>
<?php endif; ?>

<form action="login.php" method="post">
  <label for="name">Nome: </label>
  <input type="text" name="name" value="" required><br>
  <label for="password">Senha: </label>
  <input type="password" name="password" value="" required><br>

  <input type="submit" name="submit" value="Entrar">
</form>

<ul>
    <li><a href="register.php">Registrar</a></li>
  <li><a href="index.php">Voltar</a></li>
</ul>
</p>
</body>
</html>
