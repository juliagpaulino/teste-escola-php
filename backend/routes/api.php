<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Adicione os imports para os controllers:
use App\Http\Controllers\Api\AlunoController;
use App\Http\Controllers\Api\TurmaController;
use App\Http\Controllers\Api\MatriculaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::apiResource('alunos', AlunoController::class);
Route::apiResource('turmas', TurmaController::class);
Route::apiResource('matriculas', MatriculaController::class);

// endpoint para relatório de chamadas (alunos de uma turma)
Route::get('turmas/{id}/chamada', [TurmaController::class, 'chamada']);
