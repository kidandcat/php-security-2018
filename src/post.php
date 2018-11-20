<?php
session_start();

if($_SESSION["logged"] != true){
    echo "No tienes permiso!";
    return;
}

if(isset($_POST["name"]) && $_SESSION["csrf_token"] !== $_POST["csrf_token"]){
    echo "Ataque CSRF!!!";
    return;
}


$rand = "IHASD123123";
$_SESSION["csrf_token"] = $rand;

if(isset($_POST["name"])){
    $_SESSION["name"] = $_POST["name"];
    echo "I have saved your name!";
}else{
    echo isset($_SESSION["name"]) ? "Hello ".$_SESSION["name"]."!" : "I don't know your name yet";
}

