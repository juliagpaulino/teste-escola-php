<template>
  <div class="card">
    <h2>Cadastrar Nova Turma</h2>
    <form @submit.prevent="cadastrarTurma">
      <div class="form-group">
        <label for="descricao">Descrição (Ex: "1 Ano", "2 Ano B"):</label>
        <input id="descricao" type="text" v-model="form.descricao" required />
      </div>
      <div class="form-group">
        <label for="ano">Ano (Ex: 2024):</label>
        <input id="ano" type="number" v-model.number="form.ano" required />
      </div>
      <div class="form-group">
        <label for="vagas">Nº de Vagas:</label>
        <input id="vagas" type="number" v-model.number="form.vagas" required />
      </div>
      <button type="submit">Cadastrar Turma</button>
    </form>
    <p v-if="mensagem" :class="{ sucesso: sucesso, erro: !sucesso }">
      {{ mensagem }}
    </p>
  </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";

const API_URL_TURMAS = "http://teste-escola.lndo.site/api/turmas";

const form = ref({
  descricao: "",
  ano: new Date().getFullYear(),
  vagas: 30,
});
const mensagem = ref("");
const sucesso = ref(false);

const cadastrarTurma = async () => {
  mensagem.value = "";
  try {
    const response = await axios.post(API_URL_TURMAS, form.value);
    mensagem.value = `Turma "${response.data.descricao} (${response.data.ano})" cadastrada com sucesso!`;
    sucesso.value = true;
    form.value = { descricao: "", ano: new Date().getFullYear(), vagas: 30 };
  } catch (error) {
    sucesso.value = false;

    // --- CATCH MELHORADO PARA DESCOBRIR O ERRO ---
    if (error.response) {
      // Se for um erro de validação (422)
      if (error.response.status === 422) {
        mensagem.value =
          "Erro de validação: " +
          Object.values(error.response.data.errors)[0][0];

        // Se for um erro de servidor (500)
      } else if (error.response.status === 500) {
        // O Laravel (em modo debug) envia a mensagem de erro
        if (error.response.data && error.response.data.message) {
          // VAI MOSTRAR A MENSAGEM DE ERRO REAL DO PHP!
          mensagem.value = `Erro no Backend: ${error.response.data.message}`;
        } else {
          mensagem.value =
            "Erro 500: Ocorreu um erro interno no servidor (sem detalhes).";
        }
        console.error("Erro 500 Detalhado:", error.response);

        // Outros erros (404, 403, etc)
      } else {
        mensagem.value = `Erro ${error.response.status}: ${
          error.response.data.message || "Erro inesperado."
        }`;
      }
    } else {
      // Erro de rede (API fora do ar)
      mensagem.value = "Erro de rede. O backend está rodando?";
      console.error(error);
    }
  }
};
</script>

<style scoped>
/* Estilos */
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
