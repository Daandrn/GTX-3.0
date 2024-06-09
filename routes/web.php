<?php

use App\Http\Controllers\AreaLogadaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\MembroController;
use App\Http\Controllers\RecuperaSenhaController;
use App\Http\Controllers\SalaVideosController;

use App\tests\Testes;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('login', [InicioController::class, 'inicioLogin'])->name('login');
Route::post('novo', [InicioController::class, 'inicioRecruit'])->name('novo');

Route::get('/', [InicioController::class, 'index'])->name('inicio');

Route::delete('excluir', [MembroController::class, 'delete'])->name('excluir');
Route::patch('alteracanalstream', [MembroController::class, 'alteraCanalStream'])->name('alteracanalstream');
Route::patch('limpacanalstream', [MembroController::class, 'limpaCanalStream'])->name('limpacanalstream');
Route::patch('alteranick', [MembroController::class, 'alteraNick'])->name('alteranick');
Route::patch('alterasenha', [MembroController::class, 'alteraSenha'])->name('alterasenha');
Route::patch('alterastatusmembro', [MembroController::class, 'alteraStatusMembro'])->name('alterastatusmembro');
Route::get('membros', [MembroController::class, 'listaMembros'])->name('listaMembros');

Route::post('recuperasenha', [RecuperaSenhaController::class, 'recuperarSenha'])->name('recuperarSenha');
Route::post('aprovasenha', [RecuperaSenhaController::class, 'aprovaSenha'])->name('aprovasenha');
Route::post('reprovasenha', [RecuperaSenhaController::class, 'reprovaSenha'])->name('reprovasenha');

Route::post('sair', [AreaLogadaController::class, 'exit'])->name('sair');
Route::get('arealogada', [AreaLogadaController::class, 'index'])->name('arealogada');

Route::get('saladevideos', [SalaVideosController::class, 'index'])->name('saladevideos');

Route::get('teste', [Testes::class, 'init'])->name('teste');
