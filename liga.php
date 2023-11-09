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
  
  

<label for="selec">Você já tem uma liga?</label>
<input type="radio" name="sliga" id="1" value="1"> Sim <br>
<input type="radio" name="sliga" id="0" value="0"> Não
<div id="Liga">
        <div id="tem">
        <label for="loginliga">Nome da liga </label>
            <input type="text" name="loginliga" id="loginliga">
            <br>
        <label for="codliga">Código da liga </label>
            <input type="password" name="codliga" id="codliga">
            <br>
        </div>
        <div id="ntem">
        <label for="nomeliga">Nome da liga </label>
            <input type="text" name="nomeliga" id="nomeliga">
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

<script>
       var ntem = document.getElementById("ntem");
        var tem = document.getElementById("tem");
        tem.style.display = "none";
        function getResponse() {
        if(document.getElementById("1").checked) {
            tem.style.display = "block";
            ntem.style.display = "none";
        } else if(document.getElementById("0").checked) {
            ntem.style.display = "block";
            tem.style.display = "none";
        }
    }

    document.getElementById("1").addEventListener("click", getResponse);
    document.getElementById("0").addEventListener("click", getResponse);
</script>
</body>
</html>
