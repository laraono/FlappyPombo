<?php
require_once "funcoes.php";
require "nav.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
cadastroUsuario($userName);
// cadastroLiga($userName, $liga);
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>FlappyPombo - Registre-se!</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  
  <form action="register.php" method="post">
    <div class="card border border-dark-subtle rounded my-5 mx-auto col-6">
      <?php if ($success): ?>
        <div class="card-header bg-success bg-gradient p-2 text-white">
        <p>Sucesso!</p>
        <meta http-equiv="refresh" content="1; URL=login.php" />
        </div>
      <?php endif; ?>
      
      <?php if ($error): ?>
        <div class="card-header bg-danger bg-gradient p-2 text-white">
        <p><?php echo $error_msg; ?></p>
        </div>
      <?php endif; ?>
      <div class="card-body text-center my-3">
      <h2>Registro</h2>
      <hr>
      <?php if($userName==NULL): ?>
        <label for="name" class="form-label">Nome de Usuário: </label>
        <input type="text" name="name" class="form-control" value="<?php echo $userName; ?>" required><br>
    
        <label for="password" class="form-label">Senha: </label>
        <input type="password" name="password" class="form-control" value="" required><br>
    
        <label for="confirm_password" class="form-label">Confirmação da Senha: </label>
        <input type="password" name="confirm_password" value="" class="form-control" required><br>
      <?php endif;?>
       
      <input type="submit" name="submit" value="Criar usuário" class="btn btn-dark col-3" ><br><br>
      <a href="register.php" class="my-3">Fazer login</a>
      </div>
      </div>
</form>

</body>
</html>
