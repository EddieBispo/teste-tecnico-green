<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tarefa;
use Illuminate\Support\Facades\Log;

class TarefaController extends Controller
{
    public function criarTarefa(Request $request) {
        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'due_date' => 'required|date'
            ]);

            $novaTarefa = Tarefa::create([
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'status' => 'pending'
            ]);

            return response()->json([
                'message' => 'Tarefa criada com sucesso!',
                'tarefa' => $novaTarefa
            ], 201);
        } catch (\Exception $e) {
            Log::error('Erro ao criar tarefa: ' . $e->getMessage());
            return response()->json(['message' => 'Erro interno ao criar tarefa'], 500);
        }
    }

    public function listarTarefas() {
        $tarefas = Tarefa::with('subtarefas')->get();

        return response()->json($tarefas);
    }

    public function alterarTarefa(Request $request, $id) {
        $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'sometimes|date'
        ]);

        $tarefa->update($request->only(['title', 'description', 'due_date']));

        return response()->json(['message' => 'Tarefa atualizada com sucesso', 'tarefa' => $tarefa]);
    }

    public function alterarStatusTarefa(Request $request, $id) {
        $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $request->validate([
            'status' => 'required|string|in:pending,in_progress,completed'
        ]);

        $tarefa->status = $request->status;
        $tarefa->save();

        return response()->json(['message' => 'Status da tarefa atualizado com sucesso', 'tarefa' => $tarefa]);
    }

    public function deletarTarefa($id) {
        $tarefa = Tarefa::find($id);

        if (!$tarefa) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $tarefa->delete();

        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }
}
