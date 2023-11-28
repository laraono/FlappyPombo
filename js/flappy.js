"use strict";
// Obtém elementos do DOM
let game = document.getElementById("game");
let bird = document.getElementById("bird");
let timeElement = document.getElementById("time");
let scoreElement = document.getElementById("score");
let highScoreElement = document.getElementById("highScore");
let celebration = document.getElementById("celebrationDiv");
let startText = document.getElementById("startText");
let endText = document.getElementById("endText");

// Efeitos Sonoros
let deathSound = new Audio("assets/audio/death.mp3");

// Variáveis para controlar o jogo
let gameIsRunning = false;
let lastTimestamp;
let gameInterval;
let timerInterval;
let speedIncrementInterval;

// Variáveis para controlar a física do jogo
let gravity = 90; // Gravidade que puxa o pássaro para baixo
let birdPosition = 250; // Posição inicial do pássaro
let JUMP = -30; // Valor de salto do pássaro
let speed = 3; // Velocidade do jogo
let speedIncrement = 0.05; // Incremento de velocidade por segundo

// Variáveis para controlar o tempo e a pontuação
let timeInSeconds = 0;
let score = 0;
let highScore = 0;
let oldHighScore = 0;

$.ajax({
  type: "POST",
  url: "json.php",
  dataType: "json",
  success: function (data) {
    highScore = oldHighScore = data;
    highScoreElement.textContent = "Highscore: " + data;
    //console.log(data);
  },
});

// Variável de controle para rastrear se a tecla Espaço foi pressionada
let spaceKeyPressed = false;

// Variáveis para as imagens do pássaro
let normalBird = "assets/img/pombo.png"; // Sprite padrao
let damagedBird = "assets/img/pomboMachucado.png"; // Sprite de recebeu dano

// Adiciona ouvintes de eventos para iniciar o jogo quando a tecla Espaço é pressionada
document.addEventListener("keydown", (event) => {
  if (event.keyCode === 32) {
    startGame();
  }
});

// Adicione um ouvinte de eventos para reiniciar o jogo quando a tecla Espaço é pressionada após o fim do jogo
document.addEventListener("keydown", (event) => {
  if (event.keyCode === 32 && endText.style.display === "block") {
    celebration.style.display = "none"; // Oculta a div de comemoração
    endText.style.display = "none"; // Oculta a mensagem de fim de jogo
    birdPosition = 150; // Posição inicial do pássaro
    startGame(); // Inicia o jogo novamente
  }
});

// Adiciona ouvintes de eventos para detectar quando a tecla Espaço é pressionada e liberada
document.addEventListener("keydown", jump);
document.addEventListener("keyup", keyUp);

// Função para aumentar a velocidade em incrementos
function increaseSpeed() {
  if (speed < 10) {
    speed += speedIncrement;
  }
}

// Função para atualizar o tempo no formato "minutos:segundos"
function updateGameTime() {
  let minutes = Math.floor(timeInSeconds / 60);
  let seconds = timeInSeconds % 60;
  timeElement.textContent = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
  timeInSeconds++;
}

// Função para atualizar a pontuação
function updateScore() {
  score++;
  
  // Cria uma nova instância do objeto de áudio
  let scoreSound = new Audio("assets/audio/score.mp3");
  scoreSound.play();

  scoreElement.textContent = `${score}`;
  updateHighScore(); // Atualiza a highscore 
}

// Função para atualizar a melhor pontuação
function updateHighScore() {
  if (score > highScore) {
    highScore = score;
    highScoreElement.textContent = `Highscore: ${highScore}`;
  }
}

// Função para atualizar o estado do jogo a cada intervalo
function updateGameArea(timestamp) {
  if (!lastTimestamp) {
    lastTimestamp = timestamp;
  }

  let deltaTime = timestamp - lastTimestamp;
  lastTimestamp = timestamp;

  // Finaliza o jogo caso toque no chão
  if (birdPosition >= game.clientHeight - bird.clientHeight) {
    endGame();
    return;
  }

  // Limita a posição do pássaro para que ele não saia da tela
  if (birdPosition < 0) {
    birdPosition = 0;
  } else if (birdPosition > game.clientHeight - bird.clientHeight) {
    birdPosition = game.clientHeight - bird.clientHeight;
  }

  // Aplica a gravidade ao movimento vertical do pássaro
  birdPosition += gravity * (deltaTime / 1000);
  bird.style.top = birdPosition + "px";

  if (gameIsRunning) {
    requestAnimationFrame(updateGameArea);
  }
}

// Função para fazer o pássaro pular quando a tecla Espaço é pressionada
function jump(event) {
  if (event.keyCode === 32 && !spaceKeyPressed) {
    event.preventDefault(); // Cancela a ação padrão da tecla Espaço
    birdPosition += JUMP; // Mover o pássaro para cima
    spaceKeyPressed = true; // Define a variável de controle como verdadeira
  }
}

// Função para lidar com a liberação da tecla Espaço
function keyUp(event) {
  if (event.keyCode === 32) {
    spaceKeyPressed = false; // Define a variável de controle como falsa quando a tecla Espaço é liberada
  }
}

// Função para parar a animação e mostrar a imagem fixa
function mostrarImagemFixa() {
  // Adicione uma classe para parar a animação
  bird.classList.remove("animated");
  bird.querySelector("img").src = "assets/img/pomboMachucado.png";
}

// Função para retomar a animação
function retomarAnimacao() {
  // Remova a classe que parou a animação
  bird.classList.add("animated");
  bird.querySelector("img").src = "../assets/img/pombo.png";
}

// Função para iniciar o jogo
function startGame() {
  if (!gameIsRunning) {
    retomarAnimacao();
    gameIsRunning = true;
    lastTimestamp = null;
    requestAnimationFrame(updateGameArea);
    document.getElementById("startText").style.display = "none";
    // Inicia a criação aleatória de objetos
    createRandomObstacles();
    createRandomCards();
    createRandomAmmo();
    // Reinicia o timer, score e balas
    score = 0;
    timeElement.textContent = "0:00";
    scoreElement.textContent = "0";
    remainingAmmo = 3;
    updateAmmoUI();

    // Adicione um intervalo para atualizar o tempo a cada segundo
    timerInterval = setInterval(updateGameTime, 1000);
    // Adicione um intervalo para aumentar a velocidade gradualmente
    speedIncrementInterval = setInterval(increaseSpeed, 1000);
  }
}

// Função para encerrar o jogo
function endGame() {
  mostrarImagemFixa(); // Passaro morto
  deathSound.play();
  gameIsRunning = false;
  // Mostra a pontuação e a highScore do jogador
  endText.textContent = `Fim de jogo! Sua pontuação: ${score} - Highscore: ${highScore}. Pressione ESPAÇO para jogar novamente.`;
  endText.style.display = "block";

  $.ajax({
    type: "POST",
    url: "funcoes.php",
    data: { ponto: score, tempo: timeInSeconds },
  });

  clearInterval(timerInterval);
  timeInSeconds = 0;

  if (!gameIsRunning) {
    let bullets = document.querySelectorAll(".bullet");
    bullets.forEach((bullet) => bullet.remove());
  }

  // Pare o intervalo de incremento de velocidade
  clearInterval(speedIncrementInterval);

  // Redefina a velocidade para o valor padrão
  speed = 3;

  // Congratulacoes por atingir um novo recorde
  if (highScore > oldHighScore) {
    celebration.style.display = "block";
  }
  oldHighScore = highScore;
}

// CRIACAO DE OBSTACULOS =====================================================================================================================

// Função para criar e controlar os objetos em movimento
function createObstacle() {
  let obstacle = document.createElement("div");
  obstacle.className = "obstacle";

  // Gere uma posição vertical aleatória para o obstáculo
  let obstacleTop =
    Math.floor(Math.random() * (game.clientHeight - 100)) + "px";
  obstacle.style.top = obstacleTop;

  // Defina a posição inicial à direita da tela
  obstacle.style.left = game.clientWidth + "px";

  game.appendChild(obstacle);

  // Anima o objeto em movimento
  let obstacleInterval = setInterval(() => {
    // Verifica se o jogo está em execução
    if (!gameIsRunning) {
      clearInterval(obstacleInterval);
      obstacle.remove();
      return;
    }

    // Elimina o obstáculo quando ele sair da tela
    if (parseInt(obstacle.style.left) < -0) {
      obstacle.remove();
      clearInterval(obstacleInterval);
    } else {
      obstacle.style.left = parseInt(obstacle.style.left) - speed + "px"; // Movimento para a esquerda
    }

    // Verifica colisão com os tiros
    let bullets = document.querySelectorAll(".bullet");
    bullets.forEach((bullet) => {
      checkBulletObstacleCollision(bullet, obstacle);
    });

    // Verifica se o pássaro tocou no obstáculo
    let birdRect = bird.getBoundingClientRect();
    let obstacleRect = obstacle.getBoundingClientRect();
    if (
      birdRect.right > obstacleRect.left &&
      birdRect.left < obstacleRect.right &&
      birdRect.bottom > obstacleRect.top &&
      birdRect.top < obstacleRect.bottom
    ) {
      endGame(); // Término do jogo quando o pássaro toca em um obstáculo
    }
  }, 20);
}

let bulletsToBreakObstacle2 = 2; // Número de balas necessárias para destruir um "obstacle2"
let obstacle2BulletCounts = {}; // Objeto para rastrear as balas recebidas por cada "obstacle2"

// Função para criar e controlar os objetos em movimento
function createObstacle2() {
  let obstacle2 = document.createElement("div");
  obstacle2.className = "obstacle2";

  // Gere uma posição vertical aleatória para o obstáculo
  let obstacleTop =
    Math.floor(Math.random() * (game.clientHeight - 100)) + "px";
  obstacle2.style.top = obstacleTop;

  // Defina a posição inicial à direita da tela
  obstacle2.style.left = game.clientWidth + "px";

  // Atribua um ID único ao "obstacle2"
  let obstacleId = "obstacle2_" + Date.now();
  obstacle2.id = obstacleId;

  game.appendChild(obstacle2);

  // Inicialize a contagem de balas recebidas para este "obstacle2"
  obstacle2BulletCounts[obstacleId] = 0;

  // Anima o objeto em movimento
  let obstacle2Interval = setInterval(() => {
    // Verifica se o jogo está em execução
    if (!gameIsRunning) {
      clearInterval(obstacle2Interval);
      obstacle2.remove();
      return;
    }

    // Elimina o obstáculo quando ele sair da tela
    if (parseInt(obstacle2.style.left) < -0) {
      obstacle2.remove();
      clearInterval(obstacle2Interval);
    } else {
      obstacle2.style.left = parseInt(obstacle2.style.left) - speed + "px"; // Movimento para a esquerda
    }

    // Verifica colisão com os tiros
    let bullets = document.querySelectorAll(".bullet");
    bullets.forEach((bullet) => {
      checkBulletObstacleCollision(bullet, obstacle2);
    });

    // Verifica se o pássaro tocou no obstáculo
    let birdRect = bird.getBoundingClientRect();
    let obstacle2Rect = obstacle2.getBoundingClientRect();
    if (
      birdRect.right > obstacle2Rect.left &&
      birdRect.left < obstacle2Rect.right &&
      birdRect.bottom > obstacle2Rect.top &&
      birdRect.top < obstacle2Rect.bottom
    ) {
      endGame(); // Término do jogo quando o pássaro toca em um obstáculo
    }
  }, 20);
}

// Função para criar e controlar os objetos em movimento
function createObstacle3() {
  let obstacle3 = document.createElement("div");
  obstacle3.className = "obstacle3";

  // Gere um número aleatório entre 1 e 3 para escolher a imagem
  let randomImageNumber = Math.floor(Math.random() * 3) + 1;

  // Defina a imagem de fundo com base no número gerado
  obstacle3.style.backgroundImage = `url(assets/img/${
    randomImageNumber === 1
      ? "green-plane.png"
      : randomImageNumber === 2
      ? "orange-plane.png"
      : "red-plane.png"
  })`;

  // Gere uma posição vertical aleatória para o obstáculo
  let obstacleTop =
    Math.floor(Math.random() * (game.clientHeight - 100)) + "px";
  obstacle3.style.top = obstacleTop;

  // Defina a posição inicial à direita da tela
  obstacle3.style.left = game.clientWidth + "px";

  game.appendChild(obstacle3);

  // Anima o objeto em movimento
  let obstacle3Interval = setInterval(() => {
    // Verifica se o jogo está em execução
    if (!gameIsRunning) {
      clearInterval(obstacle3Interval);
      obstacle3.remove();
      return;
    }

    // Elimina o obstáculo quando ele sair da tela
    if (parseInt(obstacle3.style.left) < -0) {
      obstacle3.remove();
      clearInterval(obstacle3Interval);
    } else {
      obstacle3.style.left = parseInt(obstacle3.style.left) - speed + "px"; // Movimento para a esquerda
    }

    // Verifica se o pássaro tocou no obstáculo
    let birdRect = bird.getBoundingClientRect();
    let obstacle3Rect = obstacle3.getBoundingClientRect();
    if (
      birdRect.right > obstacle3Rect.left &&
      birdRect.left < obstacle3Rect.right &&
      birdRect.bottom > obstacle3Rect.top &&
      birdRect.top < obstacle3Rect.bottom
    ) {
      endGame(); // Término do jogo quando o pássaro toca em um obstáculo
    }
  }, 20);
}

// Função para criar obstáculos aleatórios
function createRandomObstacles() {
  if (gameIsRunning) {
    let obstacleTypes = [
      "createObstacle",
      "createObstacle2",
      "createObstacle3",
    ];
    let randomObstacleType =
      obstacleTypes[Math.floor(Math.random() * obstacleTypes.length)];
    window[randomObstacleType](); // Chama uma função de criação de obstáculos aleatória

    // Ajuste a frequência de criação com base no tempo decorrido
    let minCreationInterval = 500; // Tempo mínimo entre a criação de obstáculos
    let maxCreationInterval = 5000; // Tempo máximo entre a criação de obstáculos
    let intervalDecreaseRate = 70; // Taxa de diminuição do intervalo

    // Calcule o novo intervalo com base no tempo decorrido
    let creationInterval =
      maxCreationInterval - timeInSeconds * intervalDecreaseRate;

    if (creationInterval < minCreationInterval) {
      creationInterval = minCreationInterval; // Defina um limite mínimo
    }
    //console.log(creationInterval);
    setTimeout(createRandomObstacles, creationInterval);
  }
}
// ===========================================================================================================================================
// Função para criar e posicionar as cartinhas
function createCard() {
  let card = document.createElement("div");
  card.className = "card";

  // Gere uma posição vertical aleatória para a carta
  let cardTop = Math.floor(Math.random() * (game.clientHeight - 30)) + "px";
  card.style.top = cardTop;

  // Defina a posição inicial à direita da tela
  card.style.left = game.clientWidth + "px";

  game.appendChild(card);

  // Anima o objeto em movimento
  let cardInterval = setInterval(() => {
    // Verifica se o jogo está em execução
    if (!gameIsRunning) {
      clearInterval(cardInterval);
      card.remove();
      return;
    }

    // Elimina a carta quando ela sair da tela
    if (parseInt(card.style.left) < -0) {
      card.remove();
      clearInterval(cardInterval);
    } else {
      card.style.left = parseInt(card.style.left) - speed + "px"; // Movimento para a esquerda
    }

    // Verifica se o pássaro tocou na carta
    let birdRect = bird.getBoundingClientRect();
    let cardRect = card.getBoundingClientRect();
    if (
      birdRect.right > cardRect.left &&
      birdRect.left < cardRect.right &&
      birdRect.bottom > cardRect.top &&
      birdRect.top < cardRect.bottom
    ) {
      card.remove();
      updateScore(); // Aumenta a pontuação quando o pássaro pega uma carta
    }
  }, 20);
}

// Função para criar cartinhas em intervalos
function createRandomCards() {
  if (gameIsRunning) {
    createCard();

    // Ajuste a frequência de criação com base no tempo decorrido
    let creationIntervalcards =
      Math.floor(Math.random() * (10000 - timeInSeconds * 1000)) +
      (5000 - timeInSeconds * 500);

    if (creationIntervalcards < 5000) {
      creationIntervalcards = 5000; // Limite mínimo de 5 segundos
    }

    setTimeout(createRandomCards, creationIntervalcards);
  }
}

// ===========================================================================================================================================

// Função para criar e posicionar as cartinhas
function createAmmo() {
  let ammo = document.createElement("div");
  ammo.className = "ammo";

  // Gere uma posição vertical aleatória para a carta
  let ammoTop = Math.floor(Math.random() * (game.clientHeight - 30)) + "px";
  ammo.style.top = ammoTop;

  // Defina a posição inicial à direita da tela
  ammo.style.left = game.clientWidth + "px";

  game.appendChild(ammo);

  // Anima o objeto em movimento
  let ammoInterval = setInterval(() => {
    // Verifica se o jogo está em execução
    if (!gameIsRunning) {
      clearInterval(ammoInterval);
      ammo.remove();
      return;
    }

    // Elimina a carta quando ela sair da tela
    if (parseInt(ammo.style.left) < -0) {
      ammo.remove();
      clearInterval(ammoInterval);
    } else if (parseInt(ammo.style.top) >= game.clientHeight - 20) {
      ammo.remove();
      clearInterval(ammoInterval);
    } else {
      ammo.style.left = parseInt(ammo.style.left) - speed + "px"; // Movimento para a esquerda
      ammo.style.top = parseInt(ammo.style.top) + 1 + "px"; // Movimento para baixo
    }

    // Verifica se o pássaro tocou na carta
    let birdRect = bird.getBoundingClientRect();
    let ammoRect = ammo.getBoundingClientRect();
    if (
      birdRect.right > ammoRect.left &&
      birdRect.left < ammoRect.right &&
      birdRect.bottom > ammoRect.top &&
      birdRect.top < ammoRect.bottom
    ) {
      ammo.remove();
      increaseAmmo(); // Aumenta a municao
      updateAmmoUI();
    }
  }, 20);
}

// Função para criar cartinhas em intervalos
function createRandomAmmo() {
  if (gameIsRunning) {
    createAmmo();

    // Ajuste a frequência de criação com base no tempo decorrido
    let creationIntervalammo =
      Math.floor(Math.random() * (10000 - timeInSeconds * 1000)) +
      (5000 - timeInSeconds * 500);

    if (creationIntervalammo < 5000) {
      creationIntervalammo = 5000; // Limite mínimo de 5 segundos
    }

    setTimeout(createRandomAmmo, creationIntervalammo);
  }
}
// ===========================================================================================================================================

// Codigo que controla a arma===========================================================================================================
// Variável para controlar a quantidade de munição disponível
let remainingAmmo = 3;

function increaseAmmo() {
  // Cria uma nova instância do objeto de áudio
  let ammoSound = new Audio("assets/audio/ammo.mp3");
  ammoSound.play();
  if (remainingAmmo < 3) {
    remainingAmmo++;
  }
}

// Função para disparar um tiro
function shoot() {
  if (remainingAmmo > 0) {
    // Cria uma nova instância do objeto de áudio para cada tiro
    let shotSound = new Audio("assets/audio/shot.mp3");
    shotSound.play();

    let bullet = document.createElement("div");
    bullet.className = "bullet";
    bullet.style.left =
      bird.getBoundingClientRect().right -
      game.getBoundingClientRect().left +
      "px";
    bullet.style.top = birdPosition + bird.clientHeight / 2 - 10 + "px";
    game.appendChild(bullet);

    // Mova o tiro para a direita
    let bulletInterval = setInterval(() => {
      if (gameIsRunning) {
        bullet.style.left = parseInt(bullet.style.left) + 5 + "px";

        // Verifique se o tiro saiu da tela
        if (parseInt(bullet.style.left) > game.clientWidth) {
          bullet.remove();
          clearInterval(bulletInterval);
        }
      }
    }, 20);

    remainingAmmo--; // Reduza a munição após disparar
    // Configurar a UI de munição
    updateAmmoUI();
  }
}

// Verifica a colisao da bala com um obstaculo
function checkBulletObstacleCollision(bullet, obstacle) {
  let bulletRect = bullet.getBoundingClientRect();
  let obstacleRect = obstacle.getBoundingClientRect();

  // Verifique a colisão
  if (
    bulletRect.right > obstacleRect.left &&
    bulletRect.left < obstacleRect.right &&
    bulletRect.bottom > obstacleRect.top &&
    bulletRect.top < obstacleRect.bottom
  ) {
    // Se houver colisão, remova o tiro
    bullet.remove();

    // Verifique o tipo de obstáculo
    if (obstacle.classList.contains("obstacle2")) {
      const obstacleId = obstacle.id;

      // Atualize a contagem de balas recebidas para o "obstacle2" específico
      obstacle2BulletCounts[obstacleId]++;

      // Verifique se o "obstacle2" foi destruído
      if (obstacle2BulletCounts[obstacleId] >= bulletsToBreakObstacle2) {
        obstacle.remove();
        updateScore();
      }
    } else {
      obstacle.remove(); // Outros obstáculos são removidos diretamente
      updateScore();
    }
  }
}

// Adicione um ouvinte de eventos para atirar quando a tecla "F" for pressionada
document.addEventListener("keydown", (event) => {
  if ((event.key === "f" || event.key === "F") && gameIsRunning) {
    shoot();
  }
});

function updateAmmoUI() {
  let bulletsContainer = document.getElementById("bullets");

  // Remova todas as imagens de bala existentes
  while (bulletsContainer.firstChild) {
    bulletsContainer.removeChild(bulletsContainer.firstChild);
  }

  if (remainingAmmo > 0) {
    for (let i = 0; i < remainingAmmo; i++) {
      let bulletImage = document.createElement("img");
      bulletImage.src = "assets/img/egg.png";
      bulletImage.alt = "Bala";
      bulletsContainer.appendChild(bulletImage);
    }
  }
}
//==============================================================================================================================
