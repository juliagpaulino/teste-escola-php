<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Aluno;

class AlunoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Retorna todos os alunos
    return Aluno::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validação dos dados que chegam [baseado na migration]
    $request->validate([
        'nome' => 'required|string|max:255',
        'data_nascimento' => 'required|date',
        'cpf' => 'required|string|size:11|unique:alunos',
    ]);

    // Cria o aluno no banco
    $aluno = Aluno::create($request->all());

    // Retorna o aluno criado com status 201 (Created)
    return response()->json($aluno, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
