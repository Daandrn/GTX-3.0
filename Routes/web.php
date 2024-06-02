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
    'limpacanalstream',
    'arealogada',
    'salavideos',
    'teste',
    'alteranick',
    'alterasenha',
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
Route::patch(['alteracanalstream'], AreaLogadaController::class, 'alteraCanalStream');
Route::patch(['limpacanalstream'], AreaLogadaController::class, 'limpaCanalStream');
Route::patch(['alteranick'], AreaLogadaController::class, 'alteraNick');
Route::patch(['alterasenha'], AreaLogadaController::class, 'alteraSenha');
Route::get(['arealogada'], AreaLogadaController::class, 'index');

Route::get(['salavideos'], SalaVideosController::class, 'index');

Route::get(['teste'], Testes::class, 'init');
