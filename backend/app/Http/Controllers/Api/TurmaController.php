<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Turma;

class TurmaController extends Controller
{
    public function index()
    {
        return Turma::all();
    }

    public function store(Request $request)
    {
        $dadosValidados = $request->validate([
            'descricao' => 'required|string|max:255',
            'ano' => 'required|integer|min:1900|max:2100',
            'vagas' => 'required|integer|min:1',
        ]);
        $turma = Turma::create($dadosValidados);
        return response()->json($turma, 201);
    }

    public function show(string $id) 
    { /* Não implementado */ }

    public function update(Request $request, string $id) 
    { /* Não implementado */ }

    public function destroy(string $id) 
    { /* Não implementado */ }

    public function chamada($id)
    {
        $alunos = Aluno::join('matriculas', 'alunos.id', '=', 'matriculas.id_aluno')
            ->where('matriculas.id_turma', $id)
            ->select('alunos.id', 'alunos.nome', 'alunos.data_nascimento')
            ->orderBy('alunos.nome')
            ->get();
        return response()->json($alunos);
    }
}
