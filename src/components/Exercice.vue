<template>
  <HeaderExercice :numero="store.exercice - 1" />
  <div v-if="store.niveau == 4"><RemplirSuite /></div>
</template>

<script setup>
import HeaderExercice from "./HeaderExercice.vue";
import { useKokoStore } from "../stores/index";
import { onMounted, computed } from "vue";
import RemplirSuite from "./Exercices/RemplirSuite.vue";
const store = useKokoStore();

// onMounted(() => {
//   store.getNiveauExercice();
//   store.fetchExercices();
// });
</script>
<style></style>
