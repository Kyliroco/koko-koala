let image = new Image();
image.src = '../img/koko.png';

document.addEventListener("DOMContentLoaded", function(){image.addEventListener('load', test);});

var nbBillesA = 1
var nbBillesB = 1

function test(){
    var canvas = document.getElementById("canvas1");
    var ctx = canvas.getContext("2d");
    var canvas2 = document.getElementById("canvas2");
    var ctx2 = canvas2.getContext("2d");
    nbBillesA = dessinerBilles(ctx, canvas, image)
	do{
		nbBillesB = dessinerBilles(ctx2, canvas2, image)
	}while(nbBillesB == nbBillesA)
		
	document.getElementById('canvas1').addEventListener("click", choose)
	document.getElementById('canvas2').addEventListener("click", choose)
	document.getElementById('replayButton').addEventListener("click", rejouer)
}

function dessinerBilles(ctx, canvas, image){
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    tailleBillesx = 50;
    tailleBillesy = 50;
    espaceEntreBilles = 10
    x = espaceEntreBilles;
    y = espaceEntreBilles;
    nbBilles = Math.floor(Math.random() * ((Math.floor(canvas.width/(tailleBillesx+espaceEntreBilles))*Math.floor(canvas.height/(tailleBillesy+espaceEntreBilles)))-1))+1;
    for(i=0; i<nbBilles; i++){
        ctx.drawImage(image, x, y, tailleBillesx, tailleBillesy);
        x += tailleBillesx+espaceEntreBilles
        if(x >= canvas.width-tailleBillesx){
            y += tailleBillesy+espaceEntreBilles
            x = espaceEntreBilles
        }
    }
    return nbBilles;
}

function choose(){
        if((event.target.id == "canvas1" && nbBillesA > nbBillesB) || (event.target.id == "canvas2" && nbBillesA < nbBillesB)){
            event.target.style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
        }else{
            event.target.style.filter = "drop-shadow(0px 0px 8px red) drop-shadow(0px 0px 8px red)"
            if(event.target.id == "canvas1"){
                document.getElementById('canvas2').style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
            }else{
                document.getElementById('canvas1').style.filter = "drop-shadow(0px 0px 8px green) drop-shadow(0px 0px 8px green)"
            }
        }
		document.getElementById('canvas1').removeEventListener("click", choose)
		document.getElementById('canvas2').removeEventListener("click", choose)
		document.getElementById('replayButton').style.display = "inline-block"
}

function rejouer(){
	document.getElementById('replayButton').style.display = "none"
	document.getElementById('canvas1').style.filter = ""
	document.getElementById('canvas2').style.filter = ""
	test()
}