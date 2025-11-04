<template>
  <main>
    <h1>Sistema de Matrículas Escolar</h1>

    <nav class="nav-abas">
      <button
        @click="viewAtiva = 'aluno'"
        :class="{ ativo: viewAtiva === 'aluno' }"
      >
        Cadastrar Aluno
      </button>
      <button
        @click="viewAtiva = 'turma'"
        :class="{ ativo: viewAtiva === 'turma' }"
      >
        Cadastrar Turma
      </button>
      <button
        @click="viewAtiva = 'matricula'"
        :class="{ ativo: viewAtiva === 'matricula' }"
      >
        Matricular Aluno
      </button>
      <button
        @click="viewAtiva = 'relatorio'"
        :class="{ ativo: viewAtiva === 'relatorio' }"
      >
        Relatório de Chamadas
      </button>
    </nav>

    <div class="view-container">
      <CadastroAluno v-if="viewAtiva === 'aluno'" />
      <CadastroTurma v-if="viewAtiva === 'turma'" />
      <CadastroMatricula v-if="viewAtiva === 'matricula'" />
      <RelatorioChamada v-if="viewAtiva === 'relatorio'" />
    </div>
  </main>
</template>

<script setup>
import { ref } from "vue";

// Importa TODOS os nossos componentes
import CadastroAluno from "./components/CadastroAluno.vue";
import CadastroTurma from "./components/CadastroTurma.vue";
import CadastroMatricula from "./components/CadastroMatricula.vue";
import RelatorioChamada from "./components/RelatorioChamada.vue";

// Controla qual "aba" está ativa
const viewAtiva = ref("matricula"); // Começa na tela de matricular
</script>

<style>
/* --- ESTILOS GLOBAIS --- */
:root {
  font-family: Inter, system-ui, Avenir, Helvetica, Arial, sans-serif;
  font-synthesis: none;
  text-rendering: optimizeLegibility;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color-scheme: light dark;
}

body {
  margin: 0;
  background-color: #242424;
  color: rgba(255, 255, 255, 0.87);
}

main {
  padding: 2em;
  margin: 0 auto;
  max-width: 800px;
  text-align: center;
}

/* --- ESTILOS DAS ABAS --- */
.nav-abas {
  margin-bottom: 2em;
  border-bottom: 1px solid #555;
  padding-bottom: 1em;
}

.nav-abas button {
  background: none;
  border: none;
  font-size: 1.1em;
  padding: 0.8em 1.2em;
  cursor: pointer;
  color: rgba(255, 255, 255, 0.6);
  border-bottom: 2px solid transparent;
  transition: all 0.2s;
}

.nav-abas button:hover {
  color: rgba(255, 255, 255, 0.87);
}

.nav-abas button.ativo {
  color: #646cff; /* Cor de destaque do Vue */
  border-bottom-color: #646cff;
}

/* --- ESTILOS DOS COMPONENTES (COMO JÁ TINHAMOS) --- */
table {
  width: 100%;
  margin-top: 1.5em;
  border-collapse: collapse;
  text-align: left;
}

th,
td {
  border: 1px solid #555;
  padding: 0.8em;
}

th {
  background-color: #3a3a3a;
}
</style>
