<template>
  <HeaderExercice :exercice="props.exercice" :exoParam="exoParam" :niveau="props.niveau"/>
  <div class="example-wrapper">
	<h2 style="text-align: center; padding:1rem">Compte le nombre de Koko.</h2>
    <div style="display: flex; justify-content: space-evenly; height: 256px;">
        <canvas style="border-radius: 15px; border: 1px black solid; background-color: white" id="canvas" width="256" height="256"></canvas>
    </div>
    <p>Il y a <input type="text" id="reponse" class="blank"> Koalas.</p>
    <div class="blank_3"></div>
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
        <button id="nextButton" class="button_large" style="display:none">Continuer</button>
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
        points: 10,
        pointsParQuestions: 1
    });
    for (let index = 0; index < props.exercice.niveaux.length; index++) {
        if (props.exercice.niveaux[index].numero == props.niveau) {
        niveau.value = props.exercice.niveaux[index];
        }
    }
    var limiteChiffresMin = niveau.value.min
    var limiteChiffresMax = niveau.value.max

    let image = new Image();
    image.src = '/img/koko.png';
    let imageLoaded = false;
    image.addEventListener('load', function(){imageLoaded = true});


    var fin = false

    var nbImagesParLignes = Math.ceil(Math.sqrt(limiteChiffresMax))
    var nbImages = 0

    function main(){
        if(imageLoaded){
            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext("2d");
            nbImages = Math.floor(Math.random() * (limiteChiffresMax-limiteChiffresMin))+limiteChiffresMin

            dessinerBilles(ctx, canvas, image, nbImages)

            document.getElementById('checkButton').addEventListener('click', check)
            document.getElementById('checkButton').style.display = "inline-block"
            document.getElementById('canvas').addEventListener("click", check)
            document.getElementById('nextButton').addEventListener("click", suivant)
            document.getElementById('startButton').style.display = "none"

            document.getElementById("points").textContent = exoParam.value.points;
            document.getElementById("nbQuestions").textContent = exoParam.value.nbQuestions;
            document.getElementById("questionEnCours").textContent = exoParam.value.questionEnCours;
            document.querySelector('progress').value = (exoParam.value.questionEnCours-1)*100/exoParam.value.nbQuestions;
        }
    }

    function dessinerBilles(ctx, canvas, image, nbBilles){//Fait pour des images carrées ex: 32x32, 512x512, 1024x1024
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        var tailleImages = Math.round(canvas.width/nbImagesParLignes);
        var espaceEntreImages = (canvas.width-(tailleImages*nbImagesParLignes))/nbImagesParLignes
        var x = espaceEntreImages;
        var y = espaceEntreImages;
        for(let i=0; i<nbBilles; i++){
            ctx.drawImage(image, x, y, tailleImages, tailleImages);
            x += tailleImages+espaceEntreImages
            if(x > canvas.width-tailleImages){
                y += tailleImages+espaceEntreImages
                x = espaceEntreImages
            }
        }
    }

    function check(){
        document.getElementById('checkButton').removeEventListener('click', check)
        document.getElementById('checkButton').style.display = "none"
        if(nbImages == document.getElementById('reponse').value){
            document.getElementById('reponse').classList.add('true_1')
        }else{
            document.getElementById('reponse').classList.add('false_1')
            document.getElementById('reponse').value = nbImages
            exoParam.value.points -= exoParam.value.pointsParQuestions
            document.getElementById('count_icon').style.filter = "hue-rotate(-"+((exoParam.value.pointsParQuestions*exoParam.value.nbQuestions-exoParam.value.points)*60/(exoParam.value.pointsParQuestions*exoParam.value.nbQuestions))+"deg)"
        }
        document.getElementById('canvas').removeEventListener("click", check)
        
        document.getElementById("points").textContent = exoParam.value.points;
        document.querySelector('progress').value = (exoParam.value.questionEnCours-1)*100/exoParam.value.nbQuestions;
        if(!fin){
            document.getElementById('nextButton').style.display = "inline-block"
        }else{
            document.querySelector('progress').value = (exoParam.value.questionEnCours+1)*100/exoParam.value.nbQuestions;
        }
    }

    function suivant(){
        exoParam.value.questionEnCours += 1
        document.getElementById('nextButton').removeEventListener('click', suivant)
        document.getElementById('nextButton').style.display = "none"
        document.getElementById('canvas').style.filter = ""
        document.getElementById('reponse').classList.remove('false_1')
        document.getElementById('reponse').classList.remove('true_1')
        document.getElementById('reponse').value = ""
        if(exoParam.value.questionEnCours == 10){
            fin = true
        }
        main()
    }
</script>
<style></style>
