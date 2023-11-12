<?php
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
    <section class="card">
        <div class="card-body text-center my-3">
        <h1>Olá, <?php echo $user?>! Clique aqui para iniciar uma partida:</h1>
            <div>
                <a class="btn btn-success" href=" <?php if ($userName!=NULL): ?>         
                flappy.php
                <?php else: ?> 
                login.php    
                <?php endif; ?>
                ">Iniciar partida</a>    
            </div>
        </div>
        
        
    </section>

    </body>
    </html>