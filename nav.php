<?php
require_once "funcoes.php";
$user = 'Visitante';
if ($userName!=NULL):
    $user = $userName;
 endif;
     ?>
     <nav class="navbar navbar-expand-lg bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">FlappyPombo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if ($userName!=NULL): ?>
                            <li class="nav-item"><a class="nav-link" href="profile.php"><?php echo $user ?></a></li>
                            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                            <li class="nav-item"><a class="nav-link" href="editprofile.php">Mudar dados</a></li>
                            <?php if($liga==NULL): ?>
                                <li class="nav-item"><a class="nav-link" href="liga.php">Entrar em liga</a></li>
                            <?php endif;?>
                       <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Registrar-se</a></li>
                <?php endif; ?>
                </ul>
                </div>
            </div>
    </nav>