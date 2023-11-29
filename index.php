<?php
    $cookieName = "semanal";
    //ve se o cookie já existe para nao modificar o valor dele toda vez que essa pagina é acessada
    if(!isset($_COOKIE[$cookieName])) {
        setcookie($cookieName, 0, time() + 86400 * 7, "/"); 
    }
    
    require "nav.php";
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>FlappyPombo</title>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
    <div id="index">
        <img src="assets\img\Caminhao.png" alt="Voltar">
    <div class="textblock"><p>
        Essa não! Você deixou as portas do caminhão abertas! Voe e resgate as cartas que saíram voando!
</p>
<a class="btn btn-primary col-6 mx-3" href="<?php if ($userName!=NULL): ?>flappy.php<?php else: ?>login.php<?php endif; ?>">Iniciar partida</a>    
    </div>
    </body>
    </html>