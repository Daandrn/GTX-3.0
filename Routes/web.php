<?php

namespace Routes;

use App\controllers\AreaLogadaController;
use App\controllers\MembrosController;
use App\controllers\SalaVideosController;
use App\controllers\InicioController;
use Vendor\Routes\Route;

require __DIR__.'/../Vendor/Routes/Route.php';

Route::get(['inicio', ''], InicioController::class, 'index');
Route::post(['login'], InicioController::class, 'inicioLogin');
Route::delete(['excluir'], MembrosController::class, 'delete');
Route::patch(['alterastatusmembro'], MembrosController::class, 'alteraStatusMembro');
Route::post(['novo'], InicioController::class, 'inicioRecruit');
Route::get(['arealogada'], AreaLogadaController::class, 'index');
Route::get(['salavideos'], SalaVideosController::class, 'index');
Route::get(['membros'], MembrosController::class, 'listaMembros');
