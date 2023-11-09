<?php
        require "nav.php";
        require_once "funcoes.php";

        if(isset($_POST["ponto"]) && isset($_POST["recorde"])) {
            insertPontos($userName, $_POST["ponto"], $_POST["recorde"]);
        }

        if(isset($_POST["ponto"]) && isset($_POST["tempo"])) {
            inserirPartida($userName, $_POST["ponto"], $_POST["tempo"]);
        }

      /*  historicoPartidas($userName);
        rankingGeral($userName, $liga);

        rankingGeral($userName, "");

        rankingSemanal($userName, $liga);
        rankingSemanal($userName, "");

        rankingHighScore($userName, "");*/

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <table>
       <?php // rankingHighScore($userName, "");?>  
    </table>
</body>
</html>