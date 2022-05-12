<template>
  <div id="exercice" data-form-type="other">
    <div class="blank_3"></div>
    <div id="liste"></div>
    <div class="blank_6"></div>
    <div id="actions">
      <div class="action_button">
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

  var nbChiffres = 10;
  var nbChiffresATrouver = 4;
  var chiffresATrouver = [];
  var sens = 1;
  
  if(limiteChiffresMin > limiteChiffresMax){
    sens = -1
  }

  function main(){
    dessinerListe();
    emit("mainExercice", suivant, check);
  }

  function dessinerListe(){
    document.getElementById('liste').innerHTML = ""
    chiffresATrouver = []
    let unUl = document.createElement('ul');
    unUl.classList.add('horizontal_list');
    let premierChiffre = 0;
    if(sens == 1){
      premierChiffre = Math.floor(Math.random()*(limiteChiffresMax - (nbChiffres-1) - limiteChiffresMin))+limiteChiffresMin
    }else{
      premierChiffre = Math.floor(Math.random()*(limiteChiffresMin - (nbChiffres-1) - limiteChiffresMax))+limiteChiffresMax + (nbChiffres-1)
    }
    for(let i=0; i<nbChiffresATrouver; i++){
        var chiffre = 0;
        var limiteWhile = 20
        do{
          if(sens == 1){
            chiffre = Math.floor(Math.random() * nbChiffres) + premierChiffre;
          }else{
            chiffre = Math.floor(Math.random() * (nbChiffres-1)) + (premierChiffre - (nbChiffres-1));
          }
          limiteWhile -= 1
          if(limiteWhile == 0){
              break;
          }
        }while(chiffresATrouver.includes(chiffre))
        chiffresATrouver.push(chiffre)
    }

    function ajouterUnLi(i){
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

    if(sens == 1){
      for(let i=premierChiffre; i<(nbChiffres+premierChiffre); i++){
        ajouterUnLi(i)
      }
    }else{
      for(let i=premierChiffre; i>premierChiffre-nbChiffres; i--){
        ajouterUnLi(i)
      }
    }
    document.getElementById('liste').appendChild(unUl)
  }

  function check(){
    emit("checkButton", check);
    let nouveauPoints = props.exoParam.points;

    var chiffresRemplis = document.querySelectorAll('input');
    function sorter(a, b) {
        if (a < b) return (sens*-1);
        if (a > b) return sens;
        return 0;
    }
    chiffresATrouver.sort(sorter);
    for(let i=0; i<chiffresATrouver.length; i++){
      if(chiffresATrouver[i] == chiffresRemplis[i].value){
          chiffresRemplis[i].classList.add('true_1')
      }else{
          chiffresRemplis[i].classList.add('false_1')
          chiffresRemplis[i].value = chiffresATrouver[i]
          nouveauPoints -= props.exoParam.pointsParQuestions/nbChiffresATrouver;
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
