<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstituicoesController;
use App\Http\Controllers\ConveniosController;
use App\Http\Controllers\SimulacaoController;

Route::get('/instituicoes', [InstituicoesController::class, 'index']);
Route::get('/convenios', [ConveniosController::class, 'index']);
Route::post('/simulacao', [SimulacaoController::class, 'simular']);
