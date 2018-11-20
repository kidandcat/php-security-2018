<?php


header("Access-Control-Allow-Origin: http://localhost:5000");

if($_SERVER['REQUEST_METHOD'] === "OPTIONS"){
    return;
}

echo $_SERVER['REQUEST_METHOD'];

#if($_SERVER['REQUEST_METHOD'] === "POST"){
    echo "cambio en la BD!!";
#}

