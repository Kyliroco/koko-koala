document.addEventListener("DOMContentLoaded", main);

var nbQuestions = 10
var questionEnCours = 1
var points = 40
var pointsParQuestions = Math.round(points/nbQuestions)
var fin = false

var nbChiffres = 10
var nbChiffresATrouver = 4
var limiteChiffres = 100
var chiffresATrouver = []

function main(){
    dessinerListe();
    document.getElementById("points").textContent = points;
    document.getElementById('checkButton').addEventListener('click', check)
    document.getElementById('checkButton').style.display = "inline-block"
    document.getElementById('nextButton').style.display = "none"
    document.getElementById("nbQuestions").textContent = nbQuestions;
    document.getElementById("questionEnCours").textContent = questionEnCours;
    document.querySelector('progress').value = (questionEnCours-1)*10;
}

function dessinerListe(){
    document.getElementById('liste').innerHTML = ""
    chiffresATrouver = []
    let unUl = document.createElement('ul');
    unUl.classList.add('horizontal_list');

    let premierChiffre = Math.floor(Math.random()*(limiteChiffres - nbChiffres))+1
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

    for(let i=premierChiffre; i<=(nbChiffres+premierChiffre); i++){
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
            points -= pointsParQuestions/nbChiffresATrouver;
            document.getElementById('count_icon').style.filter = "hue-rotate(-"+((pointsParQuestions*nbQuestions-points)*60/(pointsParQuestions*nbQuestions))+"deg)"
        }
    }
    document.getElementById("points").textContent = points;
    questionEnCours += 1
    document.querySelector('progress').value = (questionEnCours-1)*10;
    if(!fin){
        document.getElementById('nextButton').addEventListener('click', suivant)
        document.getElementById('nextButton').style.display = "inline-block"
    }
}

function suivant(){
    document.getElementById('nextButton').removeEventListener('click', suivant)
    document.getElementById('nextButton').style.display = "none"
    if(questionEnCours == 10){
        fin = true
    }
	main()
}