<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subtarefa;

class SubtarefaController extends Controller
{
    public function criarSubtarefa(Request $request) {

        $request->validate([
            'title' => 'required|string|max:255',
            'id_task' => 'required|integer|exists:tarefas,id',
            'description' => 'nullable|string',
            
        ]);


        $novaSubtarefa = Subtarefa::create([
            'title' => $request->title,
            'id_task' => $request->id_task,
            'description' => $request->description
        ]);


        return response()->json([
            'message' => 'Subtarefa criada com sucesso!',
            'subtarefa' => $novaSubtarefa
        ], 201);
    }

    public function alterarSubtarefa(Request $request, $id) {
        $subtarefa = Subtarefa::find($id);

        
        if (!$subtarefa) { 
            return response()->json(['message' => 'Subtarefa não encontrada'], 404); 
        }

        
        $request->validate([
            'title' => 'sometimes|string|max:255', 
            'description' => 'nullable|string',
            
        ]);

        
        $subtarefa->update($request->all());

        return response()->json([
            'message' => 'Subtarefa alterada com sucesso!',
            'subtarefa' => $subtarefa
        ]);
    }

    public function alterarStatusSubtarefa(Request $request, $id) {
        $subtarefa = Subtarefa::find($id);

        if (!$subtarefa) {
            return response()->json(['message' => 'Subtarefa não encontrada'], 404);
        }

        $request->validate([
            'status' => 'required|string|in:pending,in_progress,completed'
        ]);


        $subtarefa->status = $request->status;
        $subtarefa->save();

        return response()->json(['message' => 'Status da subtarefa atualizado com sucesso', 'subtarefa' => $subtarefa]);
    }

    public function deletarSubtarefa($id) {
        $subtarefa = Subtarefa::find($id);


        if (!$subtarefa) {
            return response() -> json([ 'message' => 'Subtarefa não encontrada'], 400);
        }

        $subtarefa -> delete();

        return response() -> json(['message' => 'Subtarefa deletada com sucesso']);
    }
}
