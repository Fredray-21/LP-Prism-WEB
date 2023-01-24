function toogleSolution(solution) {
    const melanger = document.getElementById("melanger");
    const jeu = document.getElementById("jeu");
    const modele = document.getElementById("modele");
    const message = document.getElementById("message");

    solution.value = solution.value === "Solution" ? "Puzzle" : "Solution";
    melanger.disabled = !melanger.disabled;

    if (solution.value === "Puzzle") {
        jeu.style.display = "none";
        modele.style.display = "block";
        message.innerHTML = `Voici la solution`;
    } else {
        jeu.style.display = "block";
        modele.style.display = "none";
        message.innerHTML = `Vous avez ${getGoodPlace()} bonne place sur 16`;
    }

}

function changeThemes() {
    const themes = document.getElementById("themes");
    for (let i = 0; i < 17; i++) {
        const img = document.getElementById("photo" + i);
        const imgNumber = img.getAttribute("src").split("_")[1].split(".")[0]; // pour récupérer le numéro de l'image pour ne pas remettre le jeu à zéro

        img.src = `./img/${themes.value}/${themes.value}_${imgNumber}.jpg`;
    }
}

// img/nombres/nombres_11.jpg
function melanger() {
    const themes = document.getElementById("themes");
    const message = document.getElementById("message");
    const array = []
    for (let i = 0; i < 15; i++) {
        const img = document.getElementById("photo" + i);
        let random = Math.floor(Math.random() * 15);
        while (array.includes(random)) {
            random = Math.floor(Math.random() * 15);
        }
        array.push(random);
        img.src = `img/${themes.value}/${themes.value}_${random}.jpg`;
    }
    message.innerHTML = `Vous avez ${getGoodPlace()} bonne place sur 16`;
}

function getGoodPlace() {
    let countGoodPlace = 0;
    for (let i = 0; i < 16; i++) {
        const img = document.getElementById("photo" + i);
        const imgNumber = img.getAttribute("src").split("_")[1].split(".")[0]; // pour récupérer le numéro de l'image pour ne pas remettre le jeu à zéro
        if (imgNumber == i) {
            countGoodPlace++;
        }
    }
    return countGoodPlace;
}

function getArround(imgNumber) {
    let arround = []
    if (imgNumber % 4 !== 0) { //check if the image is not on the left border
        const num = document.getElementById(`photo${imgNumber - 1}`).getAttribute("src").split("_")[1].split(".")[0];
        arround.push(num);
    }
    if (imgNumber % 4 !== 3) { //check if the image is not on the right border
        const num = document.getElementById(`photo${imgNumber + 1}`).getAttribute("src").split("_")[1].split(".")[0];
        arround.push(num);

    }
    if (imgNumber > 3) { //check if the image is not on the top border
        const num = document.getElementById(`photo${imgNumber - 4}`).getAttribute("src").split("_")[1].split(".")[0];
        arround.push(num);
    }
    if (imgNumber < 12) { //check if the image is not on the bottom border
        const num = document.getElementById(`photo${imgNumber + 4}`).getAttribute("src").split("_")[1].split(".")[0];
        arround.push(num);
    }
    arround = arround.map(Number);
    return arround
}


function deplacer(img) {
    const message = document.getElementById("message");

    const imgNumber = parseInt(img.getAttribute("src").split("_")[1].split(".")[0]);
    const imgEmpty = document.querySelector(`img[src$='15.jpg']`)
    const imgEmptyNumber = 15;
    const arround = getArround(imgNumber); // utiliser la fonction pour récupérer les images autour
    console.log(arround);

    console.log(arround.includes(imgEmptyNumber));


    if (arround.includes(imgEmptyNumber)) { // vérifier que l'image vide se trouve autour de l'image cliquée
        imgEmpty.src = img.getAttribute("src");
        img.src = `img/${document.getElementById("themes").value}/${document.getElementById("themes").value}_15.jpg`;
        message.innerHTML = `Vous avez ${getGoodPlace()} bonne place sur 16`;
        if (getGoodPlace() == 16) {
            message.innerHTML = `Bravo, vous avez gagné !`;
        }
    }
}


function MajCursor() {
    console.log("MajCursor");
}





