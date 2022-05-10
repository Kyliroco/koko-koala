<template>
  <HeaderExercice :exercice="props.exercice" :exoParam="exoParam" :niveau="props.niveau"/>
  <div id="exercice" data-form-type="other">
    <div class="blank_3"></div>
    <div id="liste"></div>
    <div class="blank_6"></div>
    <div id="actions">
      <div class="action_button">
        <button id="startButton" class="button_large" @click="main()">Commencer</button>
        <button
          id="checkButton"
          class="button_large"
          style="display: none"
          data-dashlane-label="true"
          data-dashlane-rid="4335cac74b0124f7"
          data-form-type="other"
        >
          Vérifier
        </button>
        <button id="nextButton" class="button_large" style="display: none">
          Continuer
        </button>
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
  var nbChiffres = 10;
  var nbChiffresATrouver = 4;
  var chiffresATrouver = [];

  function main(){
      dessinerListe();
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

  function dessinerListe(){
      document.getElementById('liste').innerHTML = ""
      chiffresATrouver = []
      let unUl = document.createElement('ul');
      unUl.classList.add('horizontal_list');

      let premierChiffre = Math.floor(Math.random()*(limiteChiffresMax - (nbChiffres-1) - limiteChiffresMin))+limiteChiffresMin
      for(let i=0; i<nbChiffresATrouver; i++){
          var chiffre = 0;
          var limiteWhile = 20
          do{
              chiffre = Math.floor(Math.random() * nbChiffres) + premierChiffre;
              limiteWhile -= 1
              if(limiteWhile == 0){
                  break;
              }
          }while(chiffresATrouver.includes(chiffre))
          chiffresATrouver.push(chiffre)
      }

      for(let i=premierChiffre; i<(nbChiffres+premierChiffre); i++){
          let unLi = document.createElement('li');
          if(chiffresATrouver.includes(i)){
              let unInput = document.createElement('input');
              unInput.classList.add('blank');
              unLi.appendChild(unInput)
          }else{
              let unP = document.createElement('p');
              unP.classList.add('letter_box_1');
              unP.textContent = i
              unLi.appendChild(unP)
          }
          unUl.appendChild(unLi)
      }
      document.getElementById('liste').appendChild(unUl)
  }

  function check(){
      if(document.getElementById('points')){
        document.getElementById('checkButton').removeEventListener('click', check)
        document.getElementById('checkButton').style.display = "none"

        var chiffresRemplis = document.querySelectorAll('input');
        function sorter(a, b) {
            if (a < b) return -1;
            if (a > b) return 1;
            return 0;
        }
        chiffresATrouver.sort(sorter);
        for(let i=0; i<chiffresATrouver.length; i++){
            if(chiffresATrouver[i] == chiffresRemplis[i].value){
                chiffresRemplis[i].classList.add('true_1')
            }else{
                chiffresRemplis[i].classList.add('false_1')
                chiffresRemplis[i].value = chiffresATrouver[i]
                exoParam.value.points -= exoParam.value.pointsParQuestions/nbChiffresATrouver;
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
