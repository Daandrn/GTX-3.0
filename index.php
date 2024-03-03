<?php declare(strict_types=1);

require __DIR__ . "/gtx2/funcoes/func.versao.php";

$url = explode('/' , $_SERVER['REQUEST_URI']);

switch ($url[1]) {
    case '':
    case 'inicio':
        header("location: /gtx2/control/control.inicio.php");
        break;
    case 'inicio-v1':
        header("location: /gtx1/index.php");
        break;
    case 'teste':
        header("location: /gtx2/teste/teste.php");
        break;
    default:
        http_response_code(404);
        echo "<h3>Página não encontrada.</h3>";
        break;
}
