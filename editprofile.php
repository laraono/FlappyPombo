<?php
require_once "funcoes.php";
require "nav.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    editUsuario($userName);
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


  <form action="editprofile.php" method="post" enctype="multipart/form-data">
    <div class="card border border-dark-subtle rounded my-5 mx-auto col-6">
      <?php if ($success): ?>
        <div class="card-header bg-success bg-gradient p-2 text-white">
        <p>Sucesso!</p>
        <meta http-equiv="refresh" content="1; URL=profile.php" />
        </div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="card-header bg-danger bg-gradient p-2 text-white">
        <p><?php echo $error_msg; ?></p>
        </div>
      <?php endif; ?>
      <div class="card-body text-center my-3">
      <h2>Caso não queira editar a informação deixe o campo em branco.</h2>
      <hr>
      <?php if($userName!=NULL): ?>
        <label for="password" class="form-label">Insira sua senha atual para alterar seus dados: </label>
        <input type="password" name="password" class="form-control" value="" ><br>

        <label for="new-password" class="form-label">Nova Senha: </label>
        <input type="password" name="new-password" class="form-control" value=""><br>

        <label for="confirm_password" class="form-label">Confirmação da Senha: </label>
        <input type="password" name="confirm_password" value="" class="form-control"><br>

        <label for="profile_image" class="form-label">Imagem de Perfil: </label>
        <input type="file" name="profile_image" accept="image/*" class="form-control"><br>

      <?php endif;?>

      <input type="submit" name="submit" value="Editar dados" class="btn btn-dark col-3" ><br><br>
      </div>
      </div>
</form>

</body>
</html>
