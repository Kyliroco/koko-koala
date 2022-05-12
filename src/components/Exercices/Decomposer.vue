<template>
    <div id="exercice">
        <div class="blank_3"></div>
        <div><p class="center big_element" id="nombreChoisis"></p></div>
        <div class="blank_3"></div>
        <div>
            <ul class="flex" id="liste"></ul>
        </div>
        <div class="blank_6">

        </div>
        <div id="actions">
            <div class="action_button">
                <button id="checkButton" class="button_large" style="display: none">Vérifier</button>
                <button id="nextButton" class="button_large" style="display: none">Continuer</button>
            </div>
        </div>
    </div>
</template>

<script setup>
  import { nextTick } from "vue";

  const props = defineProps({
    exercice: Object,
    exoParam: Object,
    niveau: Object
  });

  const emit = defineEmits(["defineExoParam", "mainExercice", "suivantExercice", "checkButton", "checkExercice"]);
  emit("defineExoParam", {
    nbQuestions: 10,
    questionEnCours: 1,
    points: 40,
    pointsParQuestions: 4,
    fin: false
  });

  var limiteChiffresMin = props.niveau.min
  var limiteChiffresMax = props.niveau.max
  
  nextTick(main)

  var nbChiffresATrouver = 0;
  var chiffresATrouver = [];

  function main(){
      choisirUnChiffre();
      emit("mainExercice", suivant, check);
  }

  function choisirUnChiffre(){
      document.getElementById('nombreChoisis').innerHTML = ""
      document.getElementById('liste').innerHTML = ""
      var texteListe = ["Unités", "Dizaines", "Centaines", "Milliers"]
      chiffresATrouver = []

      let chiffre = Math.floor(Math.random()*(limiteChiffresMax - limiteChiffresMin))+limiteChiffresMin
      nbChiffresATrouver = chiffre.toString().length

      for(let i=0; i<nbChiffresATrouver; i++){
          chiffresATrouver.push(chiffre.toString().charAt(nbChiffresATrouver-1-i))
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
        emit("checkButton", check);
        let nouveauPoints = props.exoParam.points;

        var chiffresRemplis = document.querySelectorAll('input');
        for(let i=0; i<chiffresATrouver.length; i++){
            if(chiffresATrouver[i] == chiffresRemplis[i].value){
                chiffresRemplis[i].classList.add('true_1')
            }else{
                chiffresRemplis[i].classList.add('false_1')
                chiffresRemplis[i].value = chiffresATrouver[i]
                nouveauPoints -= Math.round(props.exoParam.pointsParQuestions/nbChiffresATrouver);
            }
        }
        emit("checkExercice", nouveauPoints);
  }

  function suivant(){
    emit("suivantExercice", suivant);
    main()
  }
</script>
<style></style>
