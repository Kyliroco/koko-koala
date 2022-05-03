let image = new Image();
image.src = '../img/koko.png';

document.addEventListener("DOMContentLoaded", function(){image.addEventListener('load', main);});

var nbQuestions = 10
var questionEnCours = 1
var points = 50
var pointsParQuestions = Math.round(points/nbQuestions)
var fin = false

var nombresImagesMax = 10
var nbImagesParLignes = Math.ceil(Math.sqrt(nombresImagesMax))
var nbImagesA = 0
var nbImagesB = 0

function main(){
    var canvasA = document.getElementById("canvas1");
    var ctxA = canvasA.getContext("2d");
    var canvasB = document.getElementById("canvas2");
    var ctxB = canvasB.getContext("2d");
    nbImagesA = Math.floor(Math.random() * (nombresImagesMax-1))+1
	do{
		nbImagesB = Math.floor(Math.random() * (nombresImagesMax-1))+1
	}while(nbImagesB == nbImagesA)

    dessinerBilles(ctxA, canvasA, image, nbImagesA)
    dessinerBilles(ctxB, canvasB, image, nbImagesB)

	document.getElementById('canvas1').addEventListener("click", check)
	document.getElementById('canvas2').addEventListener("click", check)
	document.getElementById('nextButton').addEventListener("click", next)

    document.getElementById("points").textContent = points;
    document.getElementById("nbQuestions").textContent = nbQuestions;
    document.getElementById("questionEnCours").textContent = questionEnCours;
    document.querySelector('progress').value = (questionEnCours-1)*10;
}

function dessinerBilles(ctx, canvas, image, nbBilles){//Fait pour des images carrées ex: 32x32, 512x512, 1024x1024
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    var tailleImages = Math.round(canvas.width/nbImagesParLignes);
    var espaceEntreImages = (canvas.width-(tailleImages*nbImagesParLignes))/nbImagesParLignes
    x = espaceEntreImages;
    y = espaceEntreImages;
    for(i=0; i<nbBilles; i++){
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
            points -= pointsParQuestions
            document.getElementById('count_icon').style.filter = "hue-rotate(-"+((pointsParQuestions*nbQuestions-points)*60/(pointsParQuestions*nbQuestions))+"deg)"
            if(event.target.id == "canvas1"){
                document.getElementById('canvas2').style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
            }else{
                document.getElementById('canvas1').style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
            }
        }
		document.getElementById('canvas1').removeEventListener("click", check)
		document.getElementById('canvas2').removeEventListener("click", check)
        
        document.getElementById("points").textContent = points;
        questionEnCours += 1
        document.querySelector('progress').value = (questionEnCours-1)*10;
        if(!fin){
            document.getElementById('nextButton').style.display = "inline-block"
        }
}

function next(){
	document.getElementById('nextButton').style.display = "none"
	document.getElementById('canvas1').style.filter = ""
	document.getElementById('canvas2').style.filter = ""
    if(questionEnCours == 10){
        fin = true
    }
	main()
}