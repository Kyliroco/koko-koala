<template>
  <HeaderExercice  v-if="store.exercices[exercice - 1] && exoParam != null" :exercice="store.exercices[exercice - 1]" :exoParam="exoParam" :niveau="niveau"/>
  <component :is="comp" v-if="store.exercices[exercice - 1]" :exercice="store.exercices[exercice - 1]" :niveau="store.exercices[exercice - 1].niveaux.filter(n => n.numero == niveau)[0]" :exoParam="exoParam" @defineExoParam="defineExoParam" @mainExercice="mainExercice" @suivantExercice="suivantExercice" @checkButton="checkButton" @checkExercice="checkExercice"></component>
</template>

<script setup>
import HeaderExercice from "./HeaderExercice.vue";
import { useKokoStore } from "../stores/index";
import { onMounted, ref, computed, defineAsyncComponent } from "vue";
import { useRoute } from "vue-router";

const store = useKokoStore();
const route = useRoute();
const exercice = ref(route.params.exercice);
const niveau = ref(route.params.niveau);
var exoParam = ref(null);
onMounted(() => {
  store.fetchExercices();
});

const comp = computed(function (){
      const componentName = store.exercices[exercice.value - 1].lien || null
      return defineAsyncComponent(() => import(`./Exercices/${componentName}.vue`))
})

function defineExoParam(exoParamChild){
  exoParam.value = exoParamChild;
}

function mainExercice(suivant, check, boutonCheck = true){
  document.getElementById('startButton').style.display = "none"
  document.getElementById('nextButton').addEventListener('click', suivant)
  document.getElementById('nextButton').style.display = "none"
  if(boutonCheck){
    document.getElementById('checkButton').addEventListener('click', check)
    document.getElementById('checkButton').style.display = "inline-block"
  }

  document.getElementById("points").textContent = exoParam.value.points;
  document.getElementById("nbQuestions").textContent = exoParam.value.nbQuestions;
  document.getElementById("questionEnCours").textContent = exoParam.value.questionEnCours;
  document.querySelector('progress').value = (exoParam.value.questionEnCours-1)*100/exoParam.value.nbQuestions;
}

function checkButton(check){
  document.getElementById('checkButton').removeEventListener('click', check)
  document.getElementById('checkButton').style.display = "none"
}
function checkExercice(nouveauPoints, resultat = true){
  exoParam.value.points = nouveauPoints
  document.querySelector('progress').value = (exoParam.value.questionEnCours-1)*100/exoParam.value.nbQuestions;
  document.getElementById('count_icon').style.filter = "hue-rotate(-"+((exoParam.value.pointsParQuestions*exoParam.value.nbQuestions-exoParam.value.points)*60/(exoParam.value.pointsParQuestions*exoParam.value.nbQuestions))+"deg)"
  if(!exoParam.value.fin){
      document.getElementById('nextButton').style.display = "inline-block"
  }else{
      document.querySelector('progress').value = (exoParam.value.questionEnCours+1)*100/exoParam.value.nbQuestions;
  }
}

function suivantExercice(suivant){
  exoParam.value.questionEnCours += 1
  document.getElementById('nextButton').removeEventListener('click', suivant)
  document.getElementById('nextButton').style.display = "none"
  if(exoParam.value.questionEnCours == exoParam.value.nbQuestions){
      exoParam.value.fin = true
  }
}

</script>
<style></style>
