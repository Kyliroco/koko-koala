<template>
  <div class="example-wrapper">
	<h2 style="text-align: center; padding:1rem">Compte le nombre de Koko.</h2>
    <div style="display: flex; justify-content: space-evenly; height: 256px;">
        <canvas style="border-radius: 15px; border: 1px black solid; background-color: white" id="canvas" width="256" height="256"></canvas>
    </div>
    <p>Il y a <input type="text" id="reponse" class="blank"> Koalas.</p>
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
    var nbImages = 0

    function main(){
        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        nbImages = Math.floor(Math.random() * (limiteChiffresMax-limiteChiffresMin))+limiteChiffresMin

        dessinerBilles(ctx, canvas, image, nbImages)

        emit("mainExercice", suivant, check);
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
        emit("checkButton", check);
        let nouveauPoints = props.exoParam.points;
        if(nbImages == document.getElementById('reponse').value){
            document.getElementById('reponse').classList.add('true_1')
        }else{
            document.getElementById('reponse').classList.add('false_1')
            document.getElementById('reponse').value = nbImages
            nouveauPoints -= props.exoParam.pointsParQuestions
        }
        emit("checkExercice", nouveauPoints);
    }

    function suivant(){
        emit("suivantExercice", suivant);
        document.getElementById('canvas').style.filter = ""
        document.getElementById('reponse').classList.remove('false_1')
        document.getElementById('reponse').classList.remove('true_1')
        document.getElementById('reponse').value = ""
        main()
    }
</script>
<style></style>
