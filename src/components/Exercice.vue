<template>
  <div v-if="exercice == 4">
    <component :is="comp" v-if="store.exercices[exercice - 1]" :exercice="store.exercices[exercice - 1]" :niveau="niveau"></component>
  </div>
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
const componentName = "RemplirSuite"
const comp = computed(function (){
      return defineAsyncComponent(() => import(`./Exercices/${componentName}.vue`))
})

</script>
<style></style>
