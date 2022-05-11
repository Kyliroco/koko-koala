<template>
  <HeaderExercice :exercice="props.exercice" :exoParam="exoParam" :niveau="props.niveau"/>
  <div class="example-wrapper">
	<h2 style="text-align: center; padding:1rem">Appuie sur la case où il y a le plus de Koko.</h2>
    <div style="display: flex; justify-content: space-evenly; height: 256px;">
        <canvas style="border-radius: 15px; border: 1px black solid; background-color: white" id="canvas1" width="256" height="256"></canvas>
        <canvas style="border-radius: 15px; border: 1px black solid; background-color: white" id="canvas2" width="256" height="256"></canvas>
    </div>
    <div class="blank_3"></div>
    <div id="actions">
      <div class="action_button">
        <button id="startButton" class="button_large" @click="main()">Commencer</button>
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
        points: 50,
        pointsParQuestions: 5
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
    var nbImagesA = 0
    var nbImagesB = 0

    function main(){
        if(imageLoaded){
            var canvasA = document.getElementById("canvas1");
            var ctxA = canvasA.getContext("2d");
            var canvasB = document.getElementById("canvas2");
            var ctxB = canvasB.getContext("2d");
            nbImagesA = Math.floor(Math.random() * (limiteChiffresMax-limiteChiffresMin))+limiteChiffresMin
            do{
                nbImagesB = Math.floor(Math.random() * (limiteChiffresMax-limiteChiffresMin))+limiteChiffresMin
            }while(nbImagesB == nbImagesA)

            dessinerBilles(ctxA, canvasA, image, nbImagesA)
            dessinerBilles(ctxB, canvasB, image, nbImagesB)

            document.getElementById('canvas1').addEventListener("click", check)
            document.getElementById('canvas2').addEventListener("click", check)
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
            if((event.target.id == "canvas1" && nbImagesA > nbImagesB) || (event.target.id == "canvas2" && nbImagesA < nbImagesB)){
                event.target.style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
            }else{
                event.target.style.filter = "drop-shadow(0px 0px 8px red) drop-shadow(0px 0px 8px red)"
                exoParam.value.points -= exoParam.value.pointsParQuestions
                document.getElementById('count_icon').style.filter = "hue-rotate(-"+((exoParam.value.pointsParQuestions*exoParam.value.nbQuestions-exoParam.value.points)*60/(exoParam.value.pointsParQuestions*exoParam.value.nbQuestions))+"deg)"
                if(event.target.id == "canvas1"){
                    document.getElementById('canvas2').style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
                }else{
                    document.getElementById('canvas1').style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
                }
            }
            document.getElementById('canvas1').removeEventListener("click", check)
            document.getElementById('canvas2').removeEventListener("click", check)
            
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
        document.getElementById('canvas1').style.filter = ""
        document.getElementById('canvas2').style.filter = ""
        if(exoParam.value.questionEnCours == 10){
            fin = true
        }
        main()
    }
</script>
<style></style>
