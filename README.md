# FlappyPombo

## Sobre o Jogo

FlappyPombo é um jogo inspirado em Flappy Bird, com uma narrativa divertida. A história envolve um pombo correio desastrado que deixou as portas do seu caminhão de cartas abertas. Agora, ele precisa coletar as cartas enquanto desvia de obstáculos como pássaros e aviões no céu.

Ao jogar FlappyPombo, o jogador guia o pombo correio a coletar cartas e destruir obstáculos lançando ovos. O objetivo do jogo é coletar o maior número de cartas e evitar ser atingido por um obstáculo o quanto puder. Assim, a pontuação é calculada de acordo com o número de cartas e o tempo de jogo.

## Como Jogar

- **Objetivo do Jogo:**

  - Coletar cartas, evitar obstáculos e permanecer no ar pelo maior tempo possível.

- **Controles:**

  - Espaço: Voar mais alto.
  - "F": Atirar ovos para destruir obstáculos.

- **Pontuação:**
  - Acumule pontos coletando cartas e evite obstáculos o quanto puder, aumentando o tempo jogado na partida.

## Antes de Começar

Antes de iniciar uma partida, certifique-se de efetuar o login em sua conta ou registrar-se caso ainda não tenha uma conta.

## Instalação

Para começar, siga estas etapas:

1. Clone o repositório via Git:
   ```bash
   git clone https://gitlab.com/trabalhopraticoweb/emojindle.git
   ```

## Instruções de Instalação

Siga os passos abaixo para configurar e iniciar o FlappyPombo:

1. Abra o aplicativo XAMPP ou uma aplicação similar.

2. Habilite o Apache e o MySQL.

3. Acesse as seguintes páginas no navegador, para a criação do banco de dados e tabelas:

   - [http://localhost/emojindle/database/create_db.php](http://localhost/emojindle/database/create_db.php)
   - [http://localhost/emojindle/database/create_tables.php](http://localhost/emojindle/database/create_tables.php)

4. Acesse a interface inicial do FlappyPombo:

   - [http://localhost/emojindle/index.php](http://localhost/emojindle/index.php)

5. Clique em "Iniciar Partida" ou "Login". Clique em "Ainda não tem uma conta?".

6. Realize o registro conforme desejado e, em seguida, faça o login.

7. Clique em "Entrar em liga" no menu superior e cadastre ou entre em uma liga existente.

8. O jogo pode ser acessado pela interface inicial novamente, clicando em "Iniciar Partida":

   - [http://localhost/emojindle/index.php](http://localhost/emojindle/index.php)

9. Para jogar, utilize os controles:

- Espaço: Voar mais alto.
- "F": Atirar ovos para destruir obstáculos.

10. Para retornar para a homepage, clique no ícone de casa, no canto inferior direito do jogo.

11. Acesse o perfil clicando no nome de usuário no menu superior. Navegue pelos rankings de liga e normais.

12. Para sair, clique em "Logout" no menu superior.

# Partes do sistema

- Homepage:
  - Página inicial contando brevemente a narrativa do jogo e convidando o usuário a jogar;
  - Disponibiliza o link para login, registro, e acesso ao jogo;
- Autenticação:
  - Criação de contas (registro);
  - Login;
  - Criação de ligas;
  - Participação em ligas;
- Perfil:
  - Resumo do usuário (nome de usuário, avatar e liga);
  - Ferramentas de edição de senha, avatar e liga;
  - Histórico de partidas;
  - Ranking de partidas semanais (na liga e geral);
  - Ranking de partidas histórico (na liga e geral);
- Jogo FlappyPombo

## Liga & Ranking de Liga

- Os jogadores podem registrar uma liga com um nome e senha ou participar de uma liga já registrada, se tiver seu nome e senha;
- A pontuação e classificação da sessão 'Ranking Semanal da Liga' (considera apenas os pontos da semana) e 'Ranking Geral da Liga' (considera todos os pontos desde a criação da liga) são exibidas em comparação com outros jogadores da mesma liga. O ranking semanal é zerado toda semana.

## Ranking Geral

- A pontuação e classificação da sessão 'Ranking Semanal' (considera apenas os pontos da semana) e 'Ranking Geral' (considera todos os pontos desde a criação do banco de dados) são exibidas em comparação com outros jogadores de FlappyPombo. O ranking semanal é zerado toda semana.

## Tecnologias Utilizadas

- HTML5
- PHP 8.2.12
- JavaScript
- CSS3
- MySQL 10.4.32
- DOM
- Bootstrap 5
- XAMPP v.8.2.12
- Apache 2.4.58

## Desenvolvedores

Este projeto foi desenvolvido pelos alunos do curso superior de Tecnologia em Análise e Desenvolvimento de Sistemas, do Setor de Educação Profissional e Tecnológica (SEPT), da Universidade Federal do Paraná (UFPR).

- Grabriela Morais Gandine
- João Pedro Abreu
- Juliano da Silva Filho
- Lara Ono Glufke Reis
- Victor Alcantara Menezes Mota

## Disciplina e Professor

Este projeto faz parte da disciplina DS122 - Desenvolvimento Web I, ministrada pelo Prof. Alexander Robert Kutzke.

## Estrutura do Projeto

| Diretório          | Arquivos / Subdiretórios               |
|---------------------|--------------------------------------|
| **assets**          |   audio                          |
|            |                   img                      |
| **CSS**             |  flappy |                                      |    
|           |  style                                                                                      |
| **database**        |    create_db.php                                   |  
|    |        create_tables.php                              |
| |         db_close_connection.php                             |
|  |      db_connection.php                          |
|  |          sanitize.php               |           
| **fotos_perfil**    |                                      |
| **js**              |         flappyjs                             |
|      |     mainjs|                                                                      |
| **autheticate**     |                                      |
| **db_credentials**  |                                      |
| **db_functions**    |                                      |
| **editprofile**     |                                      |
| **flappy**          |                                      |
| **force_authenticate** |                                  |
| **funcoes**         |                                      |
| **index**           |                                      |
| **json**            |                                      |
| **liga**            |                                      |
| **login**           |                                      |
| **logout**          |                                      |
| **nav**             |                                      |
| **profile**         |                                      |
| **README**          |                                      |
| **register**        |                                      |
| **sailiga**         |                                      |


## Agradecimentos

Agradecemos ao Prof. Alexander Robert Kutzke pela orientação durante o desenvolvimento do projeto.
