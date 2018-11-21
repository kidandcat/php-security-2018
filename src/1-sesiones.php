<?php
# http://localhost:5000/1-sesiones.php?name=Jairo

# C:\Users\jairo\AppData\Local\Temp

session_start();

$name = filter_input(INPUT_GET, 'name', FILTER_SANITIZE_SPECIAL_CHARS);

if(isset($name)){
    $_SESSION["name"] = $name;
    echo "I have saved your name!";
}else{
    echo isset($_SESSION["name"]) ? "Hello ".$_SESSION["name"]."!" : "I don't know your name yet";
}

