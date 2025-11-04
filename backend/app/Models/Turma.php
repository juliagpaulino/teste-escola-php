<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    // Código do Passo 7 do seu guia
    protected $table = 'turmas'; //
    protected $fillable = ['descricao','ano','vagas']; //

    public function matriculas() {
        return $this->hasMany(Matricula::class, 'id_turma'); //
    }
}