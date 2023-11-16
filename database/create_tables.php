<?php
  require_once "db_connection.php";

  $sql = "CREATE TABLE Usuario (
    apelido VARCHAR(20) NOT NULL PRIMARY KEY,
    senha VARCHAR(20) NOT NULL,
    foto VARCHAR(255),
    pontot INT,
    pontos INT,
    highScore INT
  )";

  $sql = "ALTER TABLE Usuario ADD COLUMN profile_image VARCHAR(255)";

  if (mysqli_query($conn, $sql)) {
      echo "Table Usuario created successfully<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn). "<br>";
  }

  $sql = "CREATE TABLE Liga (
    nome VARCHAR(30) NOT NULL PRIMARY KEY,
    senha VARCHAR(20) NOT NULL,
    foto INT
  )";

  if (mysqli_query($conn, $sql)) {
      echo "Table Liga created successfully<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn). "<br>";
  }

  $sql = "CREATE TABLE Participantes (
    nomel VARCHAR(20) NOT NULL,
    apelidou VARCHAR(30) NOT NULL,
    FOREIGN KEY (nomel) REFERENCES Liga(nome),
    FOREIGN KEY (apelidou) REFERENCES Usuario(apelido)
  )";

  if (mysqli_query($conn, $sql)) {
      echo "Table Participantes created successfully<br>";
  } else {
      echo "Error creating table: " . mysqli_error($conn). "<br>";
  }

  $sql = "CREATE TABLE Partida (
    id INT AUTO_INCREMENT NOT NULL,
    data DATE NOT NULL,
    hora TIME NOT NULL,
    pontuacao INT NOT NULL,
    tempoj TIME NOT NULL,
    apelidou VARCHAR(30) NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (apelidou) REFERENCES Usuario(apelido)
  )";


  if (mysqli_query($conn, $sql)) {
      echo "Table Partida created successfully";
  } else {
      echo "Error creating table: " . mysqli_error($conn);
  }


  require_once "db_close_connection.php";
?>
