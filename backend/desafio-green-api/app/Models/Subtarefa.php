<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model; 
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subtarefa extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'id_task', 'description', 'status'];
}
