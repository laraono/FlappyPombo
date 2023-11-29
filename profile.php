<?php
    require "nav.php";
    require_once "funcoes.php"; 
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
<div class="p-3 container border border-dark-subtle rounded my-5 mx-auto col-6">
<div class="row">
<div class="col-3">
<?php
    // Construa o caminho da imagem com base no nome de usuário
    $imagePath = "fotos_perfil/" . $userName . ".jpg";
    $width = 150; // largura desejada
    $height = 150; // altura desejada
    // Verifique se o arquivo da imagem existe antes de exibir
    if (file_exists($imagePath)) {

        echo '<img src="' . $imagePath . '" class="fotoperfil rounded-circle" alt="Minha Foto de Perfil" style="width:' . $width . 'px; height:' . $height . 'px;">';
    } else {
        echo '<img src="fotos_perfil/default.png" class="fotoperfil rounded-circle" alt="Minha Foto de Perfil" style="width:' . $width . 'px; height:' . $height . 'px;">';
    }
    ?>
</div>
<div class="col-9">
    <h2>Nome de usuário: <?php echo $userName; ?></h2>
    <h4><?php if ($liga != NULL): ?>
        Liga: <?php echo $liga; ?>
        </h4>
            <a href="sailiga.php">Sair da liga</a>

        <?php else: ?>
            <a href="liga.php">Entrar em uma liga</a>
        </h4>
        <?php endif; ?>
        <h5><a href="editprofile.php">Mudar dados</a></h5>
</div>
        </div>
</div>

<h3  class="text-center my-5">Histórico de partidas</h3>

    <?php historicoPartidas($userName, true); ?>

<div class="container">
    <div class="row">
        <div class="col">
        <h3  class="text-center my-5">Ranking Semanal</h3>
        <?php
            rankingSemanal("");
            if($liga) : 
        ?>
        <h3  class="text-center my-5">Ranking Semanal da liga</h3>
        <?php  rankingSemanal($liga); endif;  ?>
        </div>
        <div class="col">
        <h3  class="text-center my-5">Ranking Geral</h3>
        <?php
            rankingGeral("");
            if($liga) : 
        ?>
        <h3  class="text-center my-5">Ranking Geral da liga</h3>
        <?php  rankingGeral($liga); endif;  ?>
        </div>
    </div>
</div>


</body>
</html>
