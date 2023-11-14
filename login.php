<?php
require_once "funcoes.php";
require "nav.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
login($userName);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>FlappyPombo - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php if($userName!=NULL): ?>
    <h3>Você já está logado!</h3>
  <?php exit(); ?>
<?php endif; ?>

<form action="login.php" method="post" class="">
  <div class="card border border-dark-subtle rounded my-5 mx-auto col-6">
  <?php if ($error): ?>
  <div class="card-header bg-danger bg-gradient p-2 text-white"><?php echo $error_msg; ?></div>
<?php endif; ?>
    <div class="card-body text-center my-3">
      <h2>Login</h2>
      <hr>
      <label for="name" class="form-label">Nome de Usuário: </label>
      <input type="text" name="name" value="" class="form-control" required><br>
      <label for="password" class="form-label">Senha: </label>
      <input type="password" name="password" value="" class="form-control" required><br>
      <input type="submit" name="submit" value="Entrar" class="btn btn-dark col-3"> <br><br>
      <a href="register.php" class="my-3">Ainda não tem uma conta?</a>
    </div>
    
  </div>
  </form>




</body>
</html>
