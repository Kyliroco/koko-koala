<template>
  <HeaderExercice :class="'CP'" />
  <div v-if="store.exercice == 4"><RemplirSuite /></div>
</template>

<script setup>
import HeaderExercice from "./HeaderExercice.vue";
import { useKokoStore } from "../stores/index";
import { onMounted, computed } from "vue";
import RemplirSuite from "./Exercices/RemplirSuite.vue";
const store = useKokoStore();

onMounted(() => {
  store.fetchClasses();
  store.getNiveauExercice();
});
const getClasses = computed(() => {
  return store.getClasse;
});
</script>
<style></style>
