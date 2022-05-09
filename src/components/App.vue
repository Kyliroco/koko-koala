<template><router-view></router-view></template>

<script setup>
import { onMounted } from "vue";
import { useKokoStore } from "../stores/index";
const store = useKokoStore();
onMounted(() => {
  store.fetchExercices();
});
</script>
<style></style>
