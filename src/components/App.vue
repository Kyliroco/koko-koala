<template><Exercice /></template>

<script setup>
import { ref, onMounted, computed } from "vue";
import { useKokoStore } from "../stores/index";
import Exercice from "./Exercice.vue";
const store = useKokoStore();
onMounted(() => {
  store.getNiveauExercice();
  store.fetchExercices();
});
</script>
<style></style>
