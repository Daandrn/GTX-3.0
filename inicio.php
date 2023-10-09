<?php 

$url = $_SERVER['REQUEST_URI'];

if($url == "/inicio.php" || $url == "/index.php"){
    header("location: /control/control.inicio.php");
} else {
    echo "error 404";
}

?>