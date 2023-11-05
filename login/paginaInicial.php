<?php 
    require "funcoes.php";

    //esses echo só estão aqui pra testar o sistema de login
    if(isset($_SESSION["user_name"])) {
        echo $_SESSION["user_name"] . "<br>";
    } else {
        header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php"); 
    }
    if(isset($_SESSION["liga"])) {
        echo $liga;
    }
?>
<html>
    <body>
<form method="post" action="logout.php">
    <input type="submit" id="logout" name="logout" value="Logout">
</form> 

</body>
</html>

