<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'due_date', 'status'];


    public function subtarefas()
    {
        return $this->hasMany(Subtarefa::class, 'id_task');
    }
}
