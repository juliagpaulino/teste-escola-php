<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    use HasFactory;

    // Código do Passo 7 do seu guia
    protected $table = 'alunos';
    protected $fillable = ['nome','data_nascimento','cpf'];

    public function matriculas() {
        return $this->hasMany(Matricula::class, 'id_aluno');
    }
}