<template>
  <div id="exercice" data-form-type="other">
    <div class="blank_3"></div>
    <div id="bloc_addition"></div>
    <div class="blank_3"></div>
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

  var nbChiffres = 0
  if(limiteChiffresMax > 100){
    nbChiffres = Math.floor(Math.random()*3)+2
  }else{
    nbChiffres = 2
  }
  var chiffres = [];
  var somme = 0;
  var maxLength = 0;

  function main(){
    dessinerListe();
    emit("mainExercice", suivant, check);
  }

  function ajouterUnLi(unUl, i, type="p"){
    let unLi = document.createElement('li');
    if(type == "input"){
        let unInput = document.createElement('input');
        unInput.classList.add('blank');
        unLi.appendChild(unInput)
    }else{
          let unP = document.createElement('p');
          unP.classList.add('letter_box_2');
          unP.textContent = i
          unLi.appendChild(unP)
      }
    document.getElementById(unUl).appendChild(unLi)
  }

  function dessinerListe(){
    document.getElementById('bloc_addition').innerHTML = ""
    chiffres = []
    somme = 0
    for(var i = 0; i<nbChiffres+2; i++){
        if(i < nbChiffres){
            chiffres.push(Math.floor(Math.random()*(limiteChiffresMax - limiteChiffresMin))+limiteChiffresMin)
        }
        let unUl = document.createElement('ul');
        unUl.setAttribute("id", "ligne"+i)
        unUl.classList.add('horizontal_list'); 
        document.getElementById('bloc_addition').appendChild(unUl)
    }
    console.log(chiffres)
    chiffres.forEach(chiffre => somme += chiffre)
    maxLength = somme.toString().length
    ajouterUnLi("ligne"+(nbChiffres), "+")
    for(var j = -1; j<nbChiffres+1; j++){
        for(let i=0; i<maxLength; i++){
            if(j == -1){
                if(i<maxLength-1){
                    ajouterUnLi("ligne"+0, "", "input")
                }else{
                    ajouterUnLi("ligne"+0, "", "p")
                }
            }else if(j == nbChiffres){
                ajouterUnLi("ligne"+(nbChiffres+1), "", "input")
            }else{
                let iB = chiffres[j].toString().length-(maxLength-i)
                if(iB >= 0){
                    ajouterUnLi("ligne"+(j+1), chiffres[j].toString()[iB])
                }else{
                    ajouterUnLi("ligne"+(j+1), "")
                }
            }
        }
    }
  }

  function check(){
    emit("checkButton", check);
    let nouveauPoints = props.exoParam.points;

    var chiffresRemplis = document.getElementById("ligne"+(nbChiffres+1)).querySelectorAll('input');
    for(let i=0; i<somme.toString().length; i++){
      if(somme.toString()[i] == chiffresRemplis[i].value){
          chiffresRemplis[i].classList.add('true_1')
      }else{
          chiffresRemplis[i].classList.add('false_1')
          chiffresRemplis[i].value = somme.toString()[i]
          nouveauPoints -= Math.round(props.exoParam.pointsParQuestions/somme.toString().length);
      }
    }
    emit("checkExercice", nouveauPoints);
  }

  function suivant(){
    emit("suivantExercice", suivant);
    main()
  }
</script>
<style>
    #bloc_addition{
        width: 50%;
        margin: auto;
    }
    #bloc_addition ul{
        display: flex;
        justify-content: flex-end;
    }
    #bloc_addition ul li{
        padding: 0.5rem;
    }
    #bloc_addition ul:nth-last-child(2) li{
        border-bottom: black solid 2px;
    }
    .letter_box_2 {
        width: 1.8rem;
        text-align: center;
        border: none;
        height: 1rem;
        font-size: 1rem;
    }
</style>
