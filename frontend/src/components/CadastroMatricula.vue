<template>
  <div class="card">
    <h2>Cadastrar Nova Matrícula</h2>

    <form @submit.prevent="fazerMatricula">
      <div class="form-group">
        <label for="aluno">Aluno:</label>
        <select id="aluno" v-model="alunoSelecionado" required>
          <option :value="null" disabled>Selecione um aluno</option>
          <option v-for="aluno in alunos" :key="aluno.id" :value="aluno.id">
            {{ aluno.nome }} (CPF: {{ aluno.cpf }})
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="turma">Turma:</label>
        <select id="turma" v-model="turmaSelecionada" required>
          <option :value="null" disabled>Selecione uma turma</option>
          <option v-for="turma in turmas" :key="turma.id" :value="turma.id">
            {{ turma.descricao }} (Ano: {{ turma.ano }})
          </option>
        </select>
      </div>

      <div class="form-group">
        <label for="data">Data da Matrícula:</label>
        <input id="data" type="date" v-model="dataMatricula" required />
      </div>

      <button type="submit">Matricular Aluno</button>
    </form>

    <p v-if="mensagemSucesso" class="sucesso">{{ mensagemSucesso }}</p>
    <p v-if="mensagemErro" class="erro">{{ mensagemErro }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

// --- URLs da nossa API ---
const API_URL_ALUNOS = "http://teste-escola.lndo.site/api/alunos";
const API_URL_TURMAS = "http://teste-escola.lndo.site/api/turmas";
const API_URL_MATRICULAS = "http://teste-escola.lndo.site/api/matriculas";

// --- Estados reativos do formulário ---
const alunos = ref([]);
const turmas = ref([]);
const alunoSelecionado = ref(null);
const turmaSelecionada = ref(null);
const dataMatricula = ref(new Date().toISOString().split("T")[0]); // Padrão de hoje

const mensagemSucesso = ref("");
const mensagemErro = ref("");

// --- Carregar dados (onMounted é como o "document.ready") ---
onMounted(async () => {
  try {
    // Busca alunos e turmas ao carregar o componente
    const [resAlunos, resTurmas] = await Promise.all([
      axios.get(API_URL_ALUNOS),
      axios.get(API_URL_TURMAS),
    ]);
    alunos.value = resAlunos.data;
    turmas.value = resTurmas.data;
  } catch (error) {
    mensagemErro.value =
      "Erro ao carregar dados da API. O backend está rodando?";
  }
});

// --- Ação de Matricular ---
const fazerMatricula = async () => {
  // Limpa mensagens antigas
  mensagemSucesso.value = "";
  mensagemErro.value = "";

  const payload = {
    id_aluno: alunoSelecionado.value,
    id_turma: turmaSelecionada.value,
    data_matricula: dataMatricula.value,
  };

  try {
    const response = await axios.post(API_URL_MATRICULAS, payload);
    mensagemSucesso.value = `Matrícula de ${
      alunos.value.find((a) => a.id === alunoSelecionado.value).nome
    } realizada com sucesso!`;

    // Limpa o formulário (opcional)
    alunoSelecionado.value = null;
    turmaSelecionada.value = null;
  } catch (error) {
    // AQUI ESTÁ A "REGRA EXTRA" DO TESTE!
    // O backend retorna um erro 400 se a turma estiver cheia
    if (error.response && error.response.status === 400) {
      mensagemErro.value = `Erro: ${error.response.data.error}`; // "Turma sem vagas"
    } else {
      // Outros erros (API fora do ar, erro 500, etc.)
      mensagemErro.value = "Ocorreu um erro ao tentar fazer a matrícula.";
      console.error(error);
    }
  }
};
</script>

<style scoped>
.card {
  background-color: #2f2f2f; /* Fundo do card um pouco mais claro */
  padding: 2em;
  border-radius: 8px;
  margin-bottom: 2em;
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

select,
input,
button {
  padding: 0.8em;
  font-size: 1em;
  border-radius: 8px;
  border: 1px solid #555;
  background-color: #3a3a3a;
  color: rgba(255, 255, 255, 0.87);
}

button {
  background-color: #4caf50; /* Um verde bonito */
  border: none;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s;
}

button:hover {
  background-color: #45a049;
}

.sucesso {
  color: #4caf50;
  font-weight: bold;
  margin-top: 1em;
}

.erro {
  color: #f44336; /* Um vermelho para o erro */
  font-weight: bold;
  margin-top: 1em;
}
</style>
