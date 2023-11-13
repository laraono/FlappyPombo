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
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


</head>
<body>
<div class="my-5 mx-auto col-6">
    <!-- <h2><?php echo $userName; ?></h2>
    <h6><?php echo $liga; ?></h6> -->
    <a href="http://">Alterar liga</a> <br>
    <a href="http://">Sair da liga</a>
</div>

<?= $userName . " - " . $liga; ?>

<h3  class="text-center my-5">Histórico de partidas</h3>
<?php 
        historicoPartidas($userName)
        ?>
<div class="container">
    <div class="row">
        <div class="col">
        <h3  class="text-center my-5">Ranking Semanal</h3>
        <?php        rankingSemanal("") ?>
        <h3  class="text-center my-5">Ranking Semanal da liga</h3>
    <?php       rankingSemanal($liga)     ?>
        </div>
        <div class="col">
        <h3  class="text-center my-5">Ranking Geral</h3>
        <?php         rankingGeral(""); ?>
        <h3  class="text-center my-5">Ranking Geral da liga</h3>
    <?php         rankingGeral($liga); ?>
        </div>
    </div>
</div>
   
  
</body>
</html>