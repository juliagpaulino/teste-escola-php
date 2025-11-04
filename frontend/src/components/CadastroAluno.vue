<template>
  <div class="card">
    <h2>Cadastrar Novo Aluno</h2>
    <form @submit.prevent="cadastrarAluno">
      <div class="form-group">
        <label for="nome">Nome:</label>
        <input id="nome" type="text" v-model="form.nome" required />
      </div>
      <div class="form-group">
        <label for="data_nascimento">Data de Nascimento:</label>
        <input
          id="data_nascimento"
          type="date"
          v-model="form.data_nascimento"
          required
        />
      </div>
      <div class="form-group">
        <label for="cpf">CPF (só números):</label>
        <input
          id="cpf"
          type="text"
          v-model="form.cpf"
          required
          maxlength="11"
          pattern="\d{11}"
        />
      </div>
      <button type="submit">Cadastrar Aluno</button>
    </form>
    <p v-if="mensagem" :class="{ sucesso: sucesso, erro: !sucesso }">
      {{ mensagem }}
    </p>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const API_URL_ALUNOS = "http://teste-escola.lndo.site/api/alunos";

const form = ref({
  nome: "",
  data_nascimento: "",
  cpf: "",
});
const mensagem = ref("");
const sucesso = ref(false);

const cadastrarAluno = async () => {
  mensagem.value = "";
  try {
    const response = await axios.post(API_URL_ALUNOS, form.value);
    mensagem.value = `Aluno "${response.data.nome}" cadastrado com sucesso!`;
    sucesso.value = true;
    // Limpa o formulário
    form.value = { nome: "", data_nascimento: "", cpf: "" };
  } catch (error) {
    sucesso.value = false;
    if (error.response && error.response.data.errors) {
      mensagem.value = Object.values(error.response.data.errors).join(", ");
    } else {
      mensagem.value = "Erro ao cadastrar aluno. O CPF já existe?";
    }
  }
};
</script>

<style scoped>
/* Estilos copiados do outro componente para manter o padrão */
.card {
  background-color: #2f2f2f;
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
  background-color: #007bff;
  border: none;
  font-weight: bold;
  cursor: pointer;
}
.sucesso {
  color: #4caf50;
  font-weight: bold;
  margin-top: 1em;
}
.erro {
  color: #f44336;
  font-weight: bold;
  margin-top: 1em;
}
</style>
