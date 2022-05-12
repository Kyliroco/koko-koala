<template>
  <HeaderExercice  v-if="exercice && exoParam != null" :exercice="exercice" :exoParam="exoParam" :niveau="niveau"/>
  <component :is="comp" v-if="exercice" :exercice="exercice" :niveau="exercice.niveaux.filter(n => n.numero == niveau)[0]" :exoParam="exoParam" @defineExoParam="defineExoParam" @mainExercice="mainExercice" @suivantExercice="suivantExercice" @checkButton="checkButton" @checkExercice="checkExercice"></component>
</template>

<script setup>
import HeaderExercice from "./HeaderExercice.vue";
import { useKokoStore } from "../stores/index";
import { onMounted, ref, computed, defineAsyncComponent } from "vue";
import { useRoute } from "vue-router";

const store = useKokoStore();
const route = useRoute();
const exerciceId = ref(route.params.exercice);
const niveau = ref(route.params.niveau);
var exoParam = ref(null);
onMounted(() => {
  store.fetchExercices();
});

const exercice = computed(function(){return store.exercices.filter(e => e.id == exerciceId.value)[0] || null})

const comp = computed(function (){
  const componentName = exercice.value.lien || null
  return defineAsyncComponent(() => import(`./Exercices/${componentName}.vue`))
})

function defineExoParam(exoParamChild){
  exoParam.value = exoParamChild;
}

function mainExercice(suivant, check, boutonCheck = true){
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
