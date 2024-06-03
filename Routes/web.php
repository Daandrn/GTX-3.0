<?php

namespace Routes;

use App\Controllers\AreaLogadaController;
use App\Controllers\InicioController;
use App\Controllers\MembrosController;
use App\Controllers\RecuperaSenhaController;
use App\Controllers\SalaVideosController;
use App\Tests\Testes;
use Vendor\Routes\Route;

require_once __DIR__ . '/../Vendor/autoload.php';

$routes = [
    'get' => [
        '',
        'login',
        'novo',
        'inicio',
        'membros',
        'arealogada',
        'salavideos',
        'teste',
    ],
    'post' => [
        'excluir',
        'alteracanalstream',
        'limpacanalstream',
        'alteranick',
        'alterasenha',
        'alterastatusmembro',
        'recuperasenha',
        'aprovasenha',
        'reprovasenha',
        'sair',
    ],
    
];

if (Route::getRequestVerify()) {
    if (!in_array(Route::url(), $routes['get'], false)) {
        echo "Error: page not found 404.";
        http_response_code(404);
        exit;
    }
}

if (route::postRequestVerify()) {
    if (!in_array(Route::url(), $routes['post'], false)) {
        echo "Error: page not found 404.";
        http_response_code(404);
        exit;
    }
}

Route::post(['login'], InicioController::class, 'inicioLogin');
Route::post(['novo'], InicioController::class, 'inicioRecruit');
Route::get(['inicio', ''], InicioController::class, 'index');

Route::delete(['excluir'], MembrosController::class, 'delete');
Route::patch(['alteracanalstream'], MembrosController::class, 'alteraCanalStream');
Route::patch(['limpacanalstream'], MembrosController::class, 'limpaCanalStream');
Route::patch(['alteranick'], MembrosController::class, 'alteraNick');
Route::patch(['alterasenha'], MembrosController::class, 'alteraSenha');
Route::patch(['alterastatusmembro'], MembrosController::class, 'alteraStatusMembro');
Route::get(['membros'], MembrosController::class, 'listaMembros');

Route::post(['recuperasenha'], RecuperaSenhaController::class, 'recuperarSenha');
Route::post(['aprovasenha'], RecuperaSenhaController::class, 'aprovaSenha');
Route::post(['reprovasenha'], RecuperaSenhaController::class, 'reprovaSenha');

Route::post(['sair'], AreaLogadaController::class, 'exit');
Route::get(['arealogada'], AreaLogadaController::class, 'index');

Route::get(['salavideos'], SalaVideosController::class, 'index');

Route::get(['teste'], Testes::class, 'init');
