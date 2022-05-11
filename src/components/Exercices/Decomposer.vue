<template>
    <HeaderExercice :exercice="props.exercice" :exoParam="exoParam" :niveau="props.niveau"/>
    <div id="exercice">
        <div class="blank_3"></div>
        <div><p class="center big_element" id="nombreChoisis">5452</p></div>
        <div class="blank_3"></div>
        <div>
            <ul class="flex" id="liste">
                <li class="input_legend" v-if="nbChiffresATrouver >= 1"><input class="blank arround1"> Unités</li>
                <li class="input_legend" v-if="nbChiffresATrouver >= 2"><input class="blank arround1"> Dizaines</li>
                <li class="input_legend" v-if="nbChiffresATrouver >= 3"><input class="blank arround1"> Centaines</li>
                <li class="input_legend" v-if="nbChiffresATrouver >= 4"><input class="blank arround1"> Milliers</li>
            </ul>
        </div>
        <div class="blank_6">

        </div>
        <div id="actions">
            <div class="action_button">
                <button id="startButton" class="button_large" @click="main()">Commencer</button>
                <button id="checkButton" class="button_large" style="display: none">Vérifier</button>
                <button id="nextButton" class="button_large" style="display: none">Continuer</button>
            </div>
        </div>
    </div>
</template>

<script setup>
  import HeaderExercice from "../HeaderExercice.vue";
  import { useKokoStore } from "../../stores/index";
  import { useRoute, useRouter } from "vue-router";
  import { ref, computed } from "@vue/reactivity";
  import { onMounted } from "@vue/runtime-core";
  const store = useKokoStore();
  const route = useRoute();
  const router = useRouter();
  const niveau = ref();
  const props = defineProps({
    exercice: Object,
    niveau: Number
  });
  var exoParam = ref({
    nbQuestions: 10,
    questionEnCours: 1,
    points: 40,
    pointsParQuestions: 4
  });
  for (let index = 0; index < props.exercice.niveaux.length; index++) {
    if (props.exercice.niveaux[index].numero == props.niveau) {
      niveau.value = props.exercice.niveaux[index];
    }
  }
  var limiteChiffresMin = niveau.value.min
  var limiteChiffresMax = niveau.value.max
  var fin = false;
  var nbChiffresATrouver = ref(0);
  var chiffresATrouver = [];

  function main(){
      choisirUnChiffre();
      document.getElementById('checkButton').addEventListener('click', check)
      document.getElementById('checkButton').style.display = "inline-block"
      document.getElementById('startButton').style.display = "none"
      document.getElementById('nextButton').style.display = "none"
      try{
        document.getElementById("points").textContent = exoParam.value.points;
        document.getElementById("nbQuestions").textContent = exoParam.value.nbQuestions;
        document.getElementById("questionEnCours").textContent = exoParam.value.questionEnCours;
        document.querySelector('progress').value = (exoParam.value.questionEnCours-1)*100/exoParam.value.nbQuestions;
      }catch(e){
        return null
      }
  }

  function choisirUnChiffre(){
      document.getElementById('nombreChoisis').innerHTML = ""
      document.getElementById('liste').innerHTML = ""
      var texteListe = ["Unités", "Dizaines", "Centaines", "Milliers"]
      chiffresATrouver = []

      let chiffre = Math.floor(Math.random()*(limiteChiffresMax - limiteChiffresMin))+limiteChiffresMin
      nbChiffresATrouver.value = chiffre.toString().length

      for(let i=0; i<nbChiffresATrouver.value; i++){
          chiffresATrouver.push(chiffre.toString().charAt(nbChiffresATrouver.value-1-i))
          let unLi = document.createElement('li');
          unLi.classList.add("input_legend");
            let unInput = document.createElement('input');
            unInput.classList.add('blank');
            unInput.classList.add('arround1');
            unLi.appendChild(unInput)
            unLi.innerHTML += texteListe[i]
          document.getElementById('liste').appendChild(unLi)
      }

      document.getElementById('nombreChoisis').textContent = chiffre
  }

  function check(){
      if(document.getElementById('points')){
        document.getElementById('checkButton').removeEventListener('click', check)
        document.getElementById('checkButton').style.display = "none"

        var chiffresRemplis = document.querySelectorAll('input');
        for(let i=0; i<chiffresATrouver.length; i++){
            if(chiffresATrouver[i] == chiffresRemplis[i].value){
                chiffresRemplis[i].classList.add('true_1')
            }else{
                chiffresRemplis[i].classList.add('false_1')
                chiffresRemplis[i].value = chiffresATrouver[i]
                exoParam.value.points -= Math.round(exoParam.value.pointsParQuestions/nbChiffresATrouver.value);
                document.getElementById('count_icon').style.filter = "hue-rotate(-"+((exoParam.value.pointsParQuestions*exoParam.value.nbQuestions-exoParam.value.points)*60/(exoParam.value.pointsParQuestions*exoParam.value.nbQuestions))+"deg)"
            }
        }
        document.getElementById("points").textContent = exoParam.value.points;
        document.querySelector('progress').value = (exoParam.value.questionEnCours-1)*100/exoParam.value.nbQuestions;
        if(!fin){
            document.getElementById('nextButton').addEventListener('click', suivant)
            document.getElementById('nextButton').style.display = "inline-block"
        }else{
          document.querySelector('progress').value = (exoParam.value.questionEnCours+1)*100/exoParam.value.nbQuestions;
        }
      }
  }

  function suivant(){
      exoParam.value.questionEnCours += 1
      document.getElementById('nextButton').removeEventListener('click', suivant)
      document.getElementById('nextButton').style.display = "none"
      if(exoParam.value.questionEnCours == exoParam.value.nbQuestions){
          fin = true
      }
    main()
  }
</script>
<style></style>
