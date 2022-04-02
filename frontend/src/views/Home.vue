<script setup>
import router from "../router";

const redirect = (e) => {
  router.push(`/${e}`);
};
</script>

<template>
  <div class="container-main">
    <div class="div-content" v-on:click="redirect('proposta')">
      Cadastrar proposta
    </div>
    <div class="div-content" v-on:click="redirect('consulta')">
      Consultar proposta
    </div>
  </div>
</template>

<style scoped>
.container-main {
  display: flex;
  flex-direction: row;
  width: 100%;
  justify-content: space-evenly;
  align-items: center;
  text-align: center;
}
.div-content {
  background-color: rgb(118, 190, 212);
  margin-top: 20px;
  width: 20%;
  height: 20px;
  border-radius: 10px;
  font-size: 20px;
  font-weight: bold;
  padding: 20px;
}
.div-content:hover {
  background-color: rgba(155, 202, 216, 0.685);
}
</style>