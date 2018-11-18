<?php
# http://localhost:5000/1-sesiones.php?name=Jairo

# C:\Users\jairo\AppData\Local\Temp

session_start();


if(isset($_GET["name"])){
    $_SESSION["name"] = $_GET["name"];
    echo "I have saved your name!";
}else{
    echo isset($_SESSION["name"]) ? "Hello ".$_SESSION["name"]."!" : "I don't know your name yet";
}

