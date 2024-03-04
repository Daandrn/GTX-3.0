<?php

namespace Routes;

use App\controllers\MembrosController;
use App\controllers\SalaVideosController;
use App\controllers\InicioController;
use App\Models\Membros;
use Vendor\Routes\Route;
require __DIR__.'/../Vendor/Routes/Route.php';

Route::get(['inicio', ''], InicioController::class, 'index');
//Route::get(['arealogada'], AreaLogadaController::class, 'index');
Route::get(['salavideos'], SalaVideosController::class, 'index');
Route::get(['membros'], MembrosController::class, 'index');

/*switch ($url[1]) {
    case '':
    case 'inicio':
        header('location: /Controllers/inicio.php');
        break;
    case 'teste':
        header("location: /Tests/teste.php");
        break;
    default:
        http_response_code(404);
        echo "<h3>Página não encontrada.</h3>";
        break;
}*/
