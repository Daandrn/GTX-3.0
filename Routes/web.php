<?php

namespace Routes;

use App\Controllers\AreaLogadaController;
use App\Controllers\InicioController;
use App\Controllers\MembrosController;
use App\Controllers\SalaVideosController;
use App\Tests\Testes;
use Vendor\Routes\Route;

require_once __DIR__ . '/../Vendor/autoload.php';

$routes = [
    '',
    'login',
    'novo',
    'inicio',
    'excluir',
    'alterastatusmembro',
    'membros',
    'sair',
    'alteracanalstream',
    'arealogada',
    'salavideos',
    'teste',
];

if (!in_array(Route::url(), $routes, false)) {
    echo "Error: page not found 404.";
    http_response_code(404);
    exit;
}

Route::post(['login'], InicioController::class, 'inicioLogin');
Route::post(['novo'], InicioController::class, 'inicioRecruit');
Route::get(['inicio', ''], InicioController::class, 'index');

Route::delete(['excluir'], MembrosController::class, 'delete');
Route::patch(['alterastatusmembro'], MembrosController::class, 'alteraStatusMembro');
Route::get(['membros'], MembrosController::class, 'listaMembros');

Route::post(['sair'], AreaLogadaController::class, 'exit');
Route::post(['alteracanalstream'], AreaLogadaController::class, 'alteraCanalStream');
Route::get(['arealogada'], AreaLogadaController::class, 'index');

Route::get(['salavideos'], SalaVideosController::class, 'index');

Route::get(['teste'], Testes::class, 'teste');
