<template>
  <div class="card">
    <h2>Relatório de Chamadas</h2>

    <div class="form-group">
      <label for="turma-relatorio">Selecione a Turma:</label>
      <select id="turma-relatorio" v-model="idTurma" @change="buscarAlunos">
        <option :value="null" disabled>Selecione uma turma</option>
        <option v-for="t in turmas" :key="t.id" :value="t.id">
          {{ t.descricao }} (Ano: {{ t.ano }})
        </option>
      </select>
    </div>

    <p v-if="mensagemErro" class="erro">{{ mensagemErro }}</p>

    <table v-if="alunos.length > 0">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Data Nascimento</th>
          <th>Chamada</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="a in alunos" :key="a.id">
          <td>{{ a.nome }}</td>
          <td>{{ formatDate(a.data_nascimento) }}</td>
          <td></td>
        </tr>
      </tbody>
    </table>

    <p v-if="alunos.length === 0 && idTurmaSelecionado">
      Nenhum aluno encontrado para esta turma.
    </p>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// --- URLs da nossa API ---
const API_URL_TURMAS = "http://teste-escola.lndo.site/api/turmas";

// --- Estados reativos ---
const turmas = ref([]); // Lista de todas as turmas
const idTurma = ref(null); // A turma que o usuário selecionou
const alunos = ref([]); // A lista de alunos da turma selecionada
const mensagemErro = ref("");
const idTurmaSelecionado = ref(false); // Para saber se o usuário já clicou

// --- Carregar Turmas (ao carregar o componente) ---
onMounted(async () => {
  try {
    const res = await axios.get(API_URL_TURMAS);
    turmas.value = res.data;
  } catch (error) {
    mensagemErro.value = "Erro ao carregar lista de turmas.";
  }
});

// --- Ação de Buscar Alunos (ao mudar o dropdown) ---
const buscarAlunos = async () => {
  if (!idTurma.value) {
    alunos.value = []; // Limpa a tabela se nenhuma turma for selecionada
    return;
  }

  idTurmaSelecionado.value = true; // Usuário selecionou algo
  mensagemErro.value = "";

  try {
    // Busca o endpoint de "chamada"
    const res = await axios.get(
      `http://teste-escola.lndo.site/api/turmas/${idTurma.value}/chamada`
    );
    alunos.value = res.data;
  } catch (error) {
    mensagemErro.value = "Erro ao carregar lista de alunos.";
    alunos.value = [];
  }
};

// --- Função de formatar data ---
const formatDate = (d) => {
  return new Date(d).toLocaleDateString("pt-BR", { timeZone: "UTC" });
};
</script>

<style scoped>
/* Estilos copiados dos outros componentes para ficar igual */
.card {
  background-color: #2f2f2f;
  padding: 2em;
  border-radius: 8px;
  text-align: left;
}
.form-group {
  margin-bottom: 1em;
  display: flex;
  flex-direction: column;
}
.form-group label {
  margin-bottom: 0.5em;
  font-weight: bold;
}
select {
  padding: 0.8em;
  font-size: 1em;
  border-radius: 8px;
  border: 1px solid #555;
  background-color: #3a3a3a;
  color: rgba(255, 255, 255, 0.87);
  width: 100%;
}
.erro {
  color: #f44336;
  font-weight: bold;
  margin-top: 1em;
}
table {
  width: 100%;
} /* O estilo da tabela já está no App.vue global */
</style>
