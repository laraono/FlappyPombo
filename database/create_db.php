<?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "flappy_bird";

  $conn = mysqli_connect($servername, $username, $password);
  
  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $sql = "CREATE DATABASE $dbname";
  if (mysqli_query($conn, $sql)) {
      echo "Database created successfully";
  } else {
      echo "Error creating database: " . mysqli_error($conn);
  }

  require_once "db_close_connection.php";
?>
