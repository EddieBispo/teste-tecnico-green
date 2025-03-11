<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TarefaController;
use App\Http\Controllers\SubtarefaController;

Route::post('criar-tarefa', [TarefaController::class, 'criarTarefa']);
Route::get('tarefas', [TarefaController::class, 'listarTarefas']);
Route::put('alterar-tarefa/{id}', [TarefaController::class, 'alterarTarefa']);
Route::put('alterar-status-tarefa/{id}', [TarefaController::class, 'alterarStatusTarefa']); 
Route::delete('deletar-tarefa/{id}', [TarefaController::class, 'deletarTarefa']); 

Route::post('criar-subtarefa', [SubtarefaController::class, 'criarSubtarefa']);
Route::put('alterar-subtarefa/{id}', [SubtarefaController::class, 'alterarSubtarefa']);
Route::put('alterar-status-subtarefa/{id}', [SubtarefaController::class, 'alterarStatusSubtarefa']); 
Route::delete('deletar-subtarefa/{id}',  [SubtarefaController::class, 'deletarSubtarefa']);