<?php
        require "nav.php";
        require_once "funcoes.php";
    
        if(isset($_POST["ponto"]) && isset($_POST["recorde"])) {
            insertPontos($userName, $_POST["ponto"], $_POST["recorde"]);
        }

        if(isset($_POST["ponto"]) && isset($_POST["tempo"])) {
            inserirPartida($userName, $_POST["ponto"], $_POST["tempo"]);
        }
       

    //    rankingHighScore($userName, "");
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<div class="card border border-dark-subtle rounded my-5 mx-auto col-6">
<div class="card-body my-3">
    <h2>Nome de usuário: <?php echo $userName; ?></h2>
    <h4><?php if ($liga != NULL): ?>
        Liga: <?php echo $liga; ?>
        </h4>
            <a href="sailiga.php">Sair da liga</a>
        
        <?php else: ?>
            <a href="liga.php">Entrar em uma liga</a> 
        </h4>
        <?php endif; ?>
        </div>
</div>


<h3  class="text-center my-5">Histórico de partidas</h3>
<?php 
        historicoPartidas($userName)
        ?>
<div class="container">
    <div class="row">
        <div class="col">
        <h3  class="text-center my-5">Ranking Semanal</h3>
        <?php        rankingSemanal($userName, $liga) ?>
        <h3  class="text-center my-5">Ranking Semanal da liga</h3>
    <?php       rankingSemanal($userName, "")     ?>
        </div>
        <div class="col">
        <h3  class="text-center my-5">Ranking Geral</h3>
        <?php         rankingGeral($userName, $liga); ?>
        <h3  class="text-center my-5">Ranking Geral da liga</h3>
    <?php         rankingGeral($userName, ""); ?>
        </div>
    </div>
</div>
   
  
</body>
</html>