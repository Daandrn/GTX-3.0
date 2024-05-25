<?php

namespace Routes;

use App\Controllers\AreaLogadaController;
use App\Controllers\InicioController;
use App\Controllers\MembrosController;
use App\Controllers\SalaVideosController;
use Tests\Teste;
use Vendor\Routes\Route;

require_once __DIR__ . '/../Vendor/autoload.php';

Route::post(['login'], InicioController::class, 'inicioLogin');
Route::post(['novo'], InicioController::class, 'inicioRecruit');
Route::get(['inicio', ''], InicioController::class, 'index');

Route::delete(['excluir'], MembrosController::class, 'delete');
Route::patch(['alterastatusmembro'], MembrosController::class, 'alteraStatusMembro');
Route::get(['membros'], MembrosController::class, 'listaMembros');

Route::post(['sair'], AreaLogadaController::class, 'exit');
Route::get(['alteracanalstream'], AreaLogadaController::class, 'alteraCanalStream');
Route::get(['arealogada'], AreaLogadaController::class, 'index');

Route::get(['salavideos'], SalaVideosController::class, 'index');

Route::get(['teste'], Teste::class, 'teste');
