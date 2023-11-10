<?php
require_once "funcoes.php";

if($userName!=NULL) {
        $conn = connect_db();                 
        $sql = "SELECT highScore FROM usuario WHERE apelido = '$userName';";
        
        $result=mysqli_query($conn, $sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();       
            echo json_encode($row["highScore"]);            
         }
    }
?>