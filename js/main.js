// Botao - iniciar jogo
document.getElementById("startButton").addEventListener("click", startGame);

// Array de palavras aleatórias
let palavras = ["maca", "banana", "laranja", "uva", "morango"];
let pontuacao = 0;

function startGame() {
    // Escolher uma palavra aleatória
    let palavraAleatoria = palavras[Math.floor(Math.random() * palavras.length)];
    console.log(palavraAleatoria);

    // Escreve a palavra na tela
    document.getElementById("targetWordText").textContent = palavraAleatoria;

    let userInputListener = function(event) {
        if (event.key === "Enter") {
            // Obter a entrada do usuário
            let userInput = document.getElementById("userInput").value.trim();
            console.log(userInput);

            // Comparar a entrada do usuário com a palavra aleatória
            if (userInput === palavraAleatoria) {
                pontuacao++;
                document.getElementById("feedback").textContent = "Correto! Você ganhou 1 ponto.";
            } else {
                document.getElementById("feedback").textContent = "Errado! Tente novamente.";
            }

            // Atualizar a pontuação e limpar o campo de entrada
            document.getElementById("score").textContent = `Pontuação: ${pontuacao}`;
            document.getElementById("userInput").value = "";

            // Remover o ouvinte de eventos para evitar que o usuário continue digitando
            document.getElementById("userInput").removeEventListener("keyup", userInputListener);
            
            // Iniciar o próximo jogo
            setTimeout(() => {
                document.getElementById("feedback").textContent = "";
                startGame();
            }, 10000); // Esperar 10 segundos para iniciar o próximo jogo
        }
    };

    // Adicionar o ouvinte de eventos de entrada
    document.getElementById("userInput").addEventListener("keyup", userInputListener);
}
