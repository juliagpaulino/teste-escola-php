<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TesteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Limpa as tabelas antes de inserir
    DB::table('matriculas')->delete();
    DB::table('alunos')->delete();
    DB::table('turmas')->delete();

    // Alunos
    DB::table('alunos')->insert([
        ['id' => 1, 'nome' => 'Pedro Silva', 'data_nascimento' => '2000-01-01', 'cpf' => '12345678901'],
        ['id' => 2, 'nome' => 'Renato Moraes', 'data_nascimento' => '1999-12-02', 'cpf' => '22222222222'],
        ['id' => 3, 'nome' => 'Silvio de Freitas', 'data_nascimento' => '1999-11-03', 'cpf' => '33333333333'],
        ['id' => 4, 'nome' => 'João Pereira', 'data_nascimento' => '2001-05-10', 'cpf' => '44444444444'], // Novo Aluno
    ]);

    // Turmas
    DB::table('turmas')->insert([
        ['id'=>1, 'descricao'=>'1 Ano', 'ano'=>2020, 'vagas'=>30], // Turma 2020 [cite: 15-17]
        ['id'=>2, 'descricao'=>'1 Ano', 'ano'=>2019, 'vagas'=>25]  // Nova Turma 2019
    ]);

    // Matrículas (só os 3 alunos antigos na turma de 2020)
    DB::table('matriculas')->insert([
        ['id' => 1, 'id_aluno'=>1, 'id_turma'=>1, 'data_matricula' => now()],
        ['id' => 2, 'id_aluno'=>2, 'id_turma'=>1, 'data_matricula' => now()],
        ['id' => 3, 'id_aluno'=>3, 'id_turma'=>1, 'data_matricula' => now()],
    ]);
}
}
