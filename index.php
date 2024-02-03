<?php 

$url = $_SERVER['REQUEST_URI'];

require __DIR__ . "/gtx2/funcoes/func.versao.php";

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
} 

if ($url == "/testephp") {
    header("location: /gtx2/teste/teste.php");
} else {
    echo "Página não encontrada.";
}