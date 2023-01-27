<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="img/icones/fleur.ico" rel="icon" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="css/stylesDivers.css">
    <link rel="stylesheet" type="text/css" href="css/stylesBanniere.css">
    <link rel="stylesheet" type="text/css" href="css/stylesMenu.css">
    <link rel="stylesheet" type="text/css" href="css/stylesGalerie.css">
    <title>Galeries de fleurs</title>
</head>
<body>
<?php echo "<p>appel serveur à " . date('H:i:s') . "</p>"; ?>
<div id="page">
    <img id="parametres" src="img/divers/parametres.png" onclick="changer_parametres();">
    <header>
        <div id="banniere" onclick="stopper_defilement();" ondblclick="lancer_defilement();">
            <img id="1" class="img_banniere visible" alt="banniere" src="img/banniere/banniere1.jpg">
            <img id="2" class="img_banniere cachee" alt="banniere" src="img/banniere/banniere2.jpg">
            <img id="3" class="img_banniere cachee" alt="banniere" src="img/banniere/banniere3.jpg">
            <img id="4" class="img_banniere cachee" alt="banniere" src="img/banniere/banniere4.jpg">
            <img id="5" class="img_banniere cachee" alt="banniere" src="img/banniere/banniere5.jpg">
            <img id="6" class="img_banniere cachee" alt="banniere" src="img/banniere/banniere6.jpg">
        </div>
        <nav>
            <ul>
                <li><a href="#" onclick="adapter_galerie('rose')">rose</a></li>
                <li><a href="#" onclick="adapter_galerie('hortensia')">hortensia</a></li>
                <li><a href="#" onclick="adapter_galerie('fruitier')">fruitier</a></li>
                <li><a href="#" onclick="adapter_galerie('autre')">autre</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="titrePage">
            <h1><span id="titre">Galerie de fleurs</span></h1>
        </div>
        <div class='galerie'>
            <div class='ligne_galerie'>
                <img id='fleur1' class='img_galerie' alt='rose1' title='rose1.jpg'
                     src='img/fleurs/rose/rose1.jpg'>
                <img id='fleur2' class='img_galerie' alt='rose2' title='rose2.png'
                     src='img/fleurs/rose/rose2.jpg'>
                <img id='fleur3' class='img_galerie' alt='rose3' title='rose3.png'
                     src='img/fleurs/rose/rose3.jpg'>
            </div>

            <div class='ligne_galerie'>
                <img id='fleur4' class='img_galerie' alt='rose4' title='rose4.png'
                     src='img/fleurs/rose/rose4.jpg'>
                <img id='fleur5' class='img_galerie' alt='rose5' title='rose5.png'
                     src='img/fleurs/rose/rose5.jpg'>
                <img id='fleur6' class='img_galerie' alt='rose6' title='rose6.png'
                     src='img/fleurs/rose/rose6.jpg'>
            </div>
        </div>
    </main>
    <footer onmouseenter="construit_infobulle();" onmouseleave="detruit_infobulle();">
        <p>JavaScript 2023</p>
        <p>TD1 - dynamiser les pages web</p>
    </footer>
</div>

<script type="text/javascript">
    let chb = setInterval(change_banniere_v1, 1000);


    function adapter_galerie(nom) {
        for (let i = 1; i <= 6; i++) {
            let image = document.getElementById('fleur' + i);
            image.src = 'img/fleurs/' + nom + '/' + nom + i + '.jpg';
            image.title = nom + i + ".png";
            image.alt = nom + i
        }
        adapter_titre(nom);
    }

    function cacher(im) {
        im.classList.add('cachee');
        im.classList.remove('visible');
    }

    function afficher(im) {
        im.classList.add('visible');
        im.classList.remove('cachee');
    }

    function suivant(n) {
        if (n >= 6) {
            return 1
        } else {
            return parseInt(n) + 1;
        }
    }

    function change_banniere_v1() {
        const ban = document.querySelector(".visible");
        const id = ban.id;
        const nextID = suivant(id);
        const banNext = document.getElementById(nextID);
        cacher(ban);
        afficher(banNext);
    }

    function change_banniere_v2() {
        const ban = document.querySelector(".visible");
        const id = ban.id;
        const nextID = suivant(id);
        const banNext = document.getElementById(nextID);
        ban.style.transition = "opacity 3s";
        banNext.style.transition = "opacity 3s";
        cacher(ban);
        afficher(banNext);
    }

    function adapter_titre(nom) {
        const tabTitres = new Array();
        tabTitres['rose'] = 'Galerie de roses';
        tabTitres['hortensia'] = 'Galerie d’hortensias';
        tabTitres['fruitier'] = 'Galerie de fruitiers';
        tabTitres['autre'] = 'Galerie de fleurs diverses';
        document.getElementById("titre").innerHTML = tabTitres[nom];
    }

    function stopper_defilement() {
        clearInterval(chb);
    }

    function lancer_defilement() {
        chb = setInterval(change_banniere_v2, 1000);
    }

    function construit_infobulle() {
        let info = document.createElement('div');
        info.innerHTML = "<p>c'est moi la bulle !</p>";
        info.id = "bulle";
        info.style.position = "fixed";
        info.style.bottom = "100px";
        info.style.left = "200px";
        info.style.backgroundColor = "darkblue";
        info.style.color = "white";
        document.body.appendChild(info);
    }

    function detruit_infobulle() {
        let info = document.getElementById('bulle');
        document.body.removeChild(info);
    }

    function changer_parametres() {
        let currentInt = document.body.style.backgroundImage;
        if (currentInt) {
            currentInt = currentInt.split('-')[1]?.slice(0, 1);
        } else {
            currentInt = 3;
        }

        let rdm = 3;
        while (currentInt == rdm) {
            rdm = Math.floor(Math.random() * 4) + 1;
        }

        document.body.style.backgroundImage = "url(' img/background/bg-" + rdm + ".jpg')";
    }
</script>
</body>
</html>
