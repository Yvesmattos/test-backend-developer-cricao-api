<script setup>
import { ref } from "vue";
import { insertPropostaBeneficiarios } from "../api";
import router from "../router";

const inicialData = ref({
  quantidade: 1,
  beneficiarios: {
    nome: "",
    idade: 0,
    reg_plan: "",
  },
});

const insertData = ref({
  quantidade: 1,
  beneficiarios: [],
});

const counter = ref(1);

const planos = [
  { reg_cod: "reg1", nome: "Bitix Customer Plano 1" },
  { reg_cod: "reg2", nome: "Bitix Customer Plano 2" },
  { reg_cod: "reg3", nome: "Bitix Customer Plano 3" },
  { reg_cod: "reg4", nome: "Bitix Customer Plano 4" },
  { reg_cod: "reg5", nome: "Bitix Customer Plano 5" },
  { reg_cod: "reg6", nome: "Bitix Customer Plano 6" },
];

const insertBeneficiariosProposta = async (e) => {
  e.preventDefault();
  inserirBeneficiario();

  let response = await insertPropostaBeneficiarios(
    JSON.stringify(insertData.value)
  );

  alert(response.data["sucesso"]);
};

const updateCounter = () => {
  counter.value = inicialData.value.quantidade;
};

const inserirBeneficiario = () => {
  let aux = JSON.parse(JSON.stringify(inicialData.value));
  insertData.value.quantidade = aux.quantidade;
  insertData.value.beneficiarios.push(aux.beneficiarios);

  inicialData.value.beneficiarios.idade = 1;
  inicialData.value.beneficiarios.nome = "";
  inicialData.value.beneficiarios.reg_plan = "";

  counter.value--;
};
</script>
<template>
  <div>
    <button class="home btn" v-on:click="router.push(`/`)">Home</button>
    <form @submit="insertBeneficiariosProposta">
      <div class="subcontainer">
        <div class="input-container">
          <label for="name">Quantidade de beneficiários: </label>
          <input
            type="number"
            id="quantidade"
            name="quantidade"
            min="1"
            placeholder="Informe a quantidade:"
            v-model="inicialData.quantidade"
            v-on:change="updateCounter"
          />
        </div>
        <div class="input-container">
          <label for="name">Nome do beneficiário: </label>
          <input
            type="text"
            id="nome"
            name="nome"
            placeholder="Digite o seu nome:"
            v-model="inicialData.beneficiarios.nome"
          />
        </div>
        <div class="input-container">
          <label for="quantidade">Idade do beneficiario</label>
          <input
            type="number"
            min="0"
            id="idade"
            name="idade"
            placeholder="Selecione a idade:"
            v-model="inicialData.beneficiarios.idade"
          />
        </div>
        <div class="input-container">
          <label for="plano">Plano do beneficiario</label>
          <select
            name="plano"
            class="status"
            v-model="inicialData.beneficiarios.reg_plan"
          >
            <option
              v-for="(plano, index) in planos"
              :key="index"
              :value="plano.reg_cod"
            >
              {{ plano.nome }}
            </option>
          </select>
        </div>
        <hr />
        <div class="buttons">
          <input
            type="submit"
            v-if="counter === 1"
            class="btn submit-btn"
            value="Fazer cotação"
          />
          <button
            class="btn submit-btn"
            v-if="counter > 1"
            v-on:click="inserirBeneficiario"
          >
            Próximo beneficiario
          </button>
          <button class="btn" v-on:click="router.push(`/consulta`)">
            Visualizar propostas
          </button>
        </div>
      </div>
    </form>
  </div>
</template>


<style scoped>
.home {
  margin: 20px 20px !important;
}
form {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}
.subcontainer {
  padding: 5px 10px;
  text-align: left;
}
.input-container {
  padding-top: 20px;
  display: flex;
  justify-content: space-between;
}
hr {
  margin-top: 10px;
}

.input-container input,
.input-container select {
  margin-left: 10px;
  width: 200px;
  border-radius: 05px;
  height: 25px;
  padding-left: 10px;
  background-color: white;
  border: 2px solid black;
}
.btn {
  font-weight: bold;
  border: 2px solid #222;
  border-radius: 5px;
  padding: 10px;
  font-size: 16px;
  margin: 20px auto;
  cursor: pointer;
  transition: 0.5s;
}
.btn:hover {
  background: rgba(86, 167, 243, 0.644);
  border: 2px solid rgba(86, 167, 243, 0.644);
}
.submit-btn {
  background-color: #222;
  color: white;
}
.propostas-btn {
  background-color: white;
  color: #222;
}
.buttons {
  width: 100%;
  display: flex;
  justify-content: space-between;
}
ul {
  list-style: none;
}
</style>