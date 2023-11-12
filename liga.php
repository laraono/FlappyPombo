<?php
require_once "funcoes.php";
require "nav.php";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
  if($_POST["selecliga"] == "cadastro"){
    cadastroLiga($userName, $liga);
  }
  else if($_POST["selecliga"] == "login") {
    loginLiga($userName, $liga);
  }

}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Entrar em uma liga</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>



<form action="liga.php" method="post">
<div class="card border border-dark-subtle rounded my-5 mx-auto col-6">
<?php if ($error): ?>
  <div class="card-header bg-danger bg-gradient p-2 text-white">Erro: <?php echo $error_msg; ?></div>
<?php endif; ?>
<div class="card-body text-center my-3">
<p>Você deseja:</p>
<input type="radio" id="selecliga" name="selecliga" value="cadastro" checked>
<label for="selecliga" class="form-label">Cadastrar liga</label>
<br>
<input type="radio" id="selecliga" name="selecliga"  value="login">
<label for="selecliga" class="form-label">Login em liga existente</label><br>
<div id="Liga py-3">
        <label for="nomeliga" class="form-label">Nome da liga </label>
            <input type="text" name="nomeliga"  class="form-control" id="nomeliga">
            <br>
        <label for="codliga" class="form-label">Código da liga </label>
            <input type="password" name="codliga"  class="form-control" id="codliga">
            <br>
    </div> 
  <input type="submit"  class="btn btn-dark col-3" name="submit" value="Formar time!"> <br>
  <a href="index.php">Voltar</a>
  </div> 
  </div> 
</form>
</body>
</html>
