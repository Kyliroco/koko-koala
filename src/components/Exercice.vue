<template>
  <HeaderExercice :exercice="store.exercices[exercice - 1]" />
  <div v-if="exercice == 4">
    <RemplirSuite :exercice="store.exercices[exercice - 1]" />
  </div>
</template>

<script setup>
import HeaderExercice from "./HeaderExercice.vue";
import { useKokoStore } from "../stores/index";
import { onMounted, ref } from "vue";
import RemplirSuite from "./Exercices/RemplirSuite.vue";
import { useRoute } from "vue-router";

const store = useKokoStore();
console.log("Debut Exercice");
const route = useRoute();
const exercice = ref(route.params.exercice);
onMounted(() => {
  store.fetchExercices();
});
</script>
<style></style>
