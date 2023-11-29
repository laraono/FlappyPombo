<?php 
require "force_authenticate.php";

?>

<!DOCTYPE html>
<html>
<head>
  <title>Flappy Bird</title>
  <link rel="stylesheet" href="css/flappy.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-Vkoo8q+CGI5+5P1NHA26zFvVnaLoMq63x1Dl9RMwoUqqeT9d9EmP7d4P5A4VgP" crossorigin="anonymous">
</head>
<body>
        <audio id="backgroundMusic" loop autoplay>
        <source src="assets/audio/bg.mp3" type="audio/mp3">
        </audio>
        <div id="game-info">
            <div id="highScore">Highscore: 0</div>
        </div>
    <div class="page-content">
        <div id="game">
            <!-- UI -->
            <div id="backButtonContainer"><button id="backButton"><img src="assets/img/home.png">.</button></div>
            <div id="ammoUI"> <!-- 3 ovos no topo da tela -->
                <div id="bullets">
                    <img id="bullet" src="assets/img/egg.png" alt="Bala">
                    <img id="bullet" src="assets/img/egg.png" alt="Bala">
                    <img id="bullet" src="assets/img/egg.png" alt="Bala">
                </div>
            </div>
            <div id="time">0:00</div>
            <div id="score">0</div>
            <img src="assets/img/card.png" alt="Carta" class="card-img" style="width: 40px;">
            <!-- UI Fim -->
            
            <div id="bird" class="animated"> <!-- Pombo -->
                <img src="assets/img/pomboMachucado.png" alt="Bird Image">
            </div>
            <div id="startText">Pressione ESPAÇO para começar. Controles: Espaço - Saltar, F - Atirar.</div>
            <div id="endText"></div>
            <div id="celebrationDiv" style="display: none;"><!-- Mostrado quando voce perde o jogo batendo seu recorde anterior -->
                <p>Parabéns! Nova Highscore!</p>
                <img id="birdAnimation" src="assets/img/bird1.png">
                <p>Pressione ESPAÇO para continuar.</p>
            </div>
        </div>  
    </div>
  <script src="js/flappy.js"></script>
</body>
</html>