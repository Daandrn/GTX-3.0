<?php

namespace Routes;

use App\controllers\AreaLogadaController;
use App\controllers\MembrosController;
use App\controllers\SalaVideosController;
use App\controllers\InicioController;
use Vendor\Routes\Route;

require __DIR__.'/../Vendor/Routes/Route.php';

Route::post(['login'], InicioController::class, 'inicioLogin');
Route::get(['inicio', ''], InicioController::class, 'index');
Route::get(['arealogada', ''], AreaLogadaController::class, 'index');
Route::get(['salavideos'], SalaVideosController::class, 'index');
Route::get(['membros'], MembrosController::class, 'listaMembros');
