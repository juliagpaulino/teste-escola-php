<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Matricula;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Matricula::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
        'id_aluno' => 'required|exists:alunos,id',
        'id_turma' => 'required|exists:turmas,id',
        'data_matricula' => 'required|date',
    ]);

        $turma = Turma::findOrFail($request->id_turma);
        $matriculasCount = Matricula::where('id_turma', $turma->id)->count();

            if ($matriculasCount >= $turma->vagas) {
        return response()->json(['error' => 'Turma sem vagas'], 400);
    }

        $matricula = Matricula::create($request->all());
        return response()->json($matricula, 201);
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
