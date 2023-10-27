<?php 

$url = $_SERVER['REQUEST_URI'];

require __DIR__ . "/gtx2/model/model.versao.php";

if (
    $url == "/inicio.php" || 
    $url == "/index.php" || 
    $url == "/inicio" || 
    $url == "/Inicio.php" || 
    $url == "/Index.php" || 
    $url == "/Inicio" || 
    $url == "/"
    ) {
        switch (verificaVersao()) {
            case 1:
                header("location: /gtx1/index.php");
                break;
            case 2:
                header("location: /gtx2/control/control.inicio.php");
                break;
        }
} else {
    echo "error 404";
}

?>