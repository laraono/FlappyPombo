// Evita que o usuario consiga ver os arrays pelo console
(function() {
    let emojis = [
        "👧 🐰 ⏱️",
        "👶 👦 👨 🛌 🏋️ 🚶 🎥 ➡️ 📺 🌍",
        "🚀💻📷🔴",
        "🥊 🐯",
        "🦋 🌪️",
        "🐔 🏃",
        "☁️ 🗺️",
        "👑 🦍",
        "💃 🐺",
        "🌍 🐠 🤡",
        "🌍 🌬️ 🔥 💧 ❓",
        "🏰 ☁️",
        "👁️ 😐",
        "🏭 🍫",
        "👻 🚫",
        "👻 🐚",
        "🔫🤵🏿 🤵 🔫",
        "🎃",
        "🐒 🐒 🐒 🐒 🐒 🐒 🐒 🐒 🐒 🐒 🐒 🐒",
        "👴 👨 👦 👶",
        "🤴 🇪🇬",
        "🤖 🌱",
        "😱 🎥",
        "🚢 🇦🇶",
        "✨ ⚔️",
        "⭐ ↔️ ⭐",
        "🍊⚙️",
        "📞 🏠",
        "🐶 🐶 🐶 🐶 🐶",
        "😱🔪",
        "🏠🎈🎈🎈👴👦",
        "👊💥🐼",
        "😈👠"
    ];
    
    let filmes = [
        "Alice no País das Maravilhas",
        "Truman Show",
        "2001: Uma Odisseia no Espaço",
        "Rocky: Um Lutador",
        "Efeito Borboleta",
        "A Fuga das Galinhas",
        "Cloud Atlas",
        "King Kong",
        "Dança com Lobos",
        "Procurando Nemo",
        "O Quinto Elemento",
        "Laputa: O Castelo no Céu",
        "O Sexto Sentido",
        "A Fantástica Fábrica de Chocolate",
        "Os Caça-Fantasmas",
        "Ghost in the Shell",
        "Pulp Fiction",
        "Halloween",
        "Os 12 Macacos",
        "O Curioso Caso de Benjamin Button",
        "O Príncipe do Egito",
        "Wall-E",
        "Todo Mundo em Pânico",
        "Titanic",
        "Star Wars",
        "Interestelar",
        "Laranja Mecânica",
        "E.T.",
        "101 Dálmatas",
        "Pânico",
        "Up",
        "Kung Fu Panda",
        "O Diabo Veste Prada"
    ];
    

    let targetWordIndex; // Index do emoji e da resposta atual
    let score = 0;
    let time = 300; // 5 minutos em segundos
    let timer; // Permite controlar e interromper o temporizador (setInterval e clearInterval)

    let targetWordEmoji = document.getElementById("targetWordEmoji"); // Campo onde o emoji eh escrito
    let userInput = document.getElementById("userInput"); // Input que o usuario digita
    let feedback = document.getElementById("feedback"); // Texto que da feedback para o usuario (errou, acertou)
    let scoreElement = document.getElementById("score"); // Pontuacao
    let timeElement = document.getElementById("time"); // Tempo
    let startButton = document.getElementById("startButton"); // Botao de iniciar o jogo

    //============================= Funcoes ============================================
    function startGame() {
        // Pega um emoji aleatorio
        targetWordIndex = Math.floor(Math.random() * emojis.length);
        targetWordEmoji.textContent = emojis[targetWordIndex]; // Escreve o emoji na tela

        // Zera os valores para um novo jogo
        userInput.value = "";
        userInput.focus();
        feedback.textContent = "";
        score = 0;
        updateScore();
        time = 300;
        updateTime();

        timer = setInterval(function() {
            time--; // Decrementa o tempo a cada segundo
            updateTime(); // Atualiza o tempo
            if (time <= 0) {
            endGame(); // Se o tempo se esgotar, encerra o jogo
            }
        }, 1000);
    }

    // Atualiza a pontuacao do usuario 
    function updateScore() {
        scoreElement.textContent = "Pontuação: " + score;
    }

    // Separa o tempo em minutos:segundos e atualiza o valor
    function updateTime() {
        let minutes = Math.floor(time / 60);
        let seconds = time % 60;
        timeElement.textContent = "Tempo: " + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;
    }

    // Compara resposta do usuario
    function checkInput() {
        //Remove caracteres especiais, remove espacos no comeco ou fim da string, deixa tudo em lowercase
        let userGuess = userInput.value.replace(/[^a-zA-Z0-9 ]/g, '').trim().toLowerCase(); 
        let correctAnswer = filmes[targetWordIndex].replace(/[^a-zA-Z0-9 ]/g, '').trim().toLowerCase();

        // Se acertou pega um novo emoji
        if (userGuess === correctAnswer) {
            score++;
            updateScore();
            targetWordIndex = Math.floor(Math.random() * emojis.length);
            targetWordEmoji.textContent = emojis[targetWordIndex];
            userInput.value = "";
            userInput.focus();
            feedback.textContent = "Correto! Próxima palavra:";
        } else {
            feedback.textContent = "Incorreto. Tente novamente.";
            userInput.value = "";
            userInput.focus();
        }
    }

    // Termina o jogo e desativa o input
    function endGame() {
        clearInterval(timer); // Cancela o temporizador
        userInput.disabled = true; // Desativa input
        startButton.disabled = false; // Ativa botao
        feedback.textContent = "Tempo esgotado. Fim do jogo!";
    }

    //============================= Eventos ============================================
    // Iniciar o Jogo
    startButton.addEventListener("click", function() {
        startButton.disabled = true; // Desativa botao
        userInput.disabled = false; // Ativa input
        startGame();
    });

    // Checar resposta
    userInput.addEventListener("keyup", function(event) {
        if (event.key === "Enter") {
            checkInput();
        }
    });

})();