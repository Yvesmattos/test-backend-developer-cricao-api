<script setup>
import { ref } from "@vue/reactivity";
import { onMounted } from "@vue/runtime-core";
import { getPropostas } from "../api";
import router from "../router";

const data = ref([]);
const buscarPropostas = async () => {
  data.value = (await getPropostas()).data;
  console.log(data.value);
};

onMounted(() => {
  buscarPropostas();
});
</script>
<template>
  <button class="back-btn btn" v-on:click="router.push(`/`)">Home</button>

  <div class="container">
    <table id="tb_proposta">
      <tr>
        <th>Proposta ID</th>
        <th>Valor Total</th>
        <th>Quantidade Beneficiarios</th>
        <th>Detalhes</th>
      </tr>
      <tr v-for="proposta in data" :key="proposta.proposta_id">
        <td>{{ proposta.proposta_id }}</td>
        <td>R$ {{ proposta.valor_total }}</td>
        <td>{{ proposta.quantidade }}</td>
        <td>
          <div
            v-for="(beneficiario, index) in proposta.beneficiarios"
            :key="index"
            style="background-color: #bacce8;"
          >
            Beneficiário: {{ beneficiario.nome }} <br />
            Idade: {{ beneficiario.idade }} ano(s) <br />
            Plano: {{ beneficiario.nome_plano }} <br />
            Valor individual: R$ {{ beneficiario.valor_plano }}
            <hr />
          </div>
        </td>
      </tr>
    </table>
  </div>
</template>

<style scoped>

.container{
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

#tb_proposta {
  width: 80%;
  text-align: center;
  border-collapse: collapse;
  margin-top: 10px;
}

#tb_proposta th {
  background-color: rgba(86, 167, 243, 0.644);
}

#tb_proposta tr,
#tb_proposta td {
  border-bottom: 1px solid black;
  padding: 5px;
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
.back-btn {
  margin: 20px 20px !important;
  background-color: white;
  color: #222;
}
</style>