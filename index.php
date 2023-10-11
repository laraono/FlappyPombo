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
    <div class="container">
        <h1>Jogo de Palavras</h1>
        <p>Insira a palavra correta e pressione Enter para jogar.</p>
        <p id="targetWord">Palavra Alvo: <span id="targetWordText"></span></p>
        <input type="text" id="userInput" class="form-control" placeholder="Insira a palavra">
        <p id="feedback"></p>
        <p id="score">Pontuação: 0</p>
        <button class="btn btn-primary" id="startButton">Iniciar Jogo</button>
    </div>

    <script src="js/main.js"></script>
</body>
</html>