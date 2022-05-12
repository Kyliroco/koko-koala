<template>
  <div class="example-wrapper">
	<h2 style="text-align: center; padding:1rem">Appuie sur la case où il y a le plus de Koko.</h2>
    <div style="display: flex; justify-content: space-evenly; height: 256px;">
        <canvas style="border-radius: 15px; border: 1px black solid; background-color: white" id="canvas1" width="256" height="256"></canvas>
        <canvas style="border-radius: 15px; border: 1px black solid; background-color: white" id="canvas2" width="256" height="256"></canvas>
    </div>
    <div class="blank_3"></div>
    <div id="actions">
      <div class="action_button">
        <button id="nextButton" class="button_large" style="display:none">Continuer</button>
      </div>
    </div>
</div>
</template>

<script setup>
    import { useKokoStore } from "../../stores/index";
    import { nextTick } from "vue";

    const store = useKokoStore();
    const props = defineProps({
        exercice: Object,
        exoParam: Object,
        niveau: Object
    });

    const emit = defineEmits(["defineExoParam", "mainExercice", "suivantExercice", "checkButton", "checkExercice"]);
    emit("defineExoParam", {
        nbQuestions: 10,
        questionEnCours: 1,
        points: 10,
        pointsParQuestions: 1,
        fin: false
    });

    var limiteChiffresMin = props.niveau.min
    var limiteChiffresMax = props.niveau.max


    let image = new Image();
    image.src = '/img/koko.png';
    image.addEventListener('load', ()=>{nextTick(main)});

    var nbImagesParLignes = Math.ceil(Math.sqrt(limiteChiffresMax))
    var nbImagesA = 0
    var nbImagesB = 0

    function main(){
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

        emit("mainExercice", suivant, check, false);
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
        let nouveauPoints = props.exoParam.points;
        if((event.target.id == "canvas1" && nbImagesA > nbImagesB) || (event.target.id == "canvas2" && nbImagesA < nbImagesB)){
            event.target.style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
        }else{
            event.target.style.filter = "drop-shadow(0px 0px 8px red) drop-shadow(0px 0px 8px red)"
            nouveauPoints -= props.exoParam.pointsParQuestions
            if(event.target.id == "canvas1"){
                document.getElementById('canvas2').style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
            }else{
                document.getElementById('canvas1').style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
            }
        }
        document.getElementById('canvas1').removeEventListener("click", check)
        document.getElementById('canvas2').removeEventListener("click", check)

        emit("checkExercice", nouveauPoints);
    }

    function suivant(){
        emit("suivantExercice", suivant);
        document.getElementById('canvas1').style.filter = ""
        document.getElementById('canvas2').style.filter = ""
        main()
    }
</script>
<style></style>
