<template>
  <component :is="comp" v-if="store.exercices[exercice - 1]" :exercice="store.exercices[exercice - 1]" :niveau="niveau"></component>
</template>

<script setup>
import { useKokoStore } from "../stores/index";
import { onMounted, ref, computed, defineAsyncComponent } from "vue";
import { useRoute } from "vue-router";

const store = useKokoStore();
console.log("Debut Exercice");
const route = useRoute();
const exercice = ref(route.params.exercice);
const niveau = ref(route.params.niveau);
onMounted(() => {
  store.fetchExercices();
});

const comp = computed(function (){
      const componentName = store.exercices[exercice.value - 1].lien || null
      return defineAsyncComponent(() => import(`./Exercices/${componentName}.vue`))
})

</script>
<style></style>
