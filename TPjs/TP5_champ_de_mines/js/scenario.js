function gererClavier(event) {
    const k = event.keyCode;
// event est ici un keydown, et keyCode est le code de la touche pressée
    switch (k) {
        case 37 : // touche gauche
            P.mouvement(-1, 0);
            break;
        case 38 : // touche haut
            P.mouvement(0, -1);
            break;
        case 39 : // touche droite
            P.mouvement(1, 0);
            break;
        case 40 : // touche bas
            P.mouvement(0, 1);
            break;
        case 65 : // touche a
            // à compléter
            C.toogleMine();
            break;
        default :
    }
    P.trouve(T);
    P.explose(C)
}


function Random() {
    return Math.floor(Math.random() * 20) + 1;
}

function startGame() {
    T.placer();
    P.placer();
}

// variables globales
let T = new Tresor(Random());
let P = new Personnage(Random());
let proba = 0.15;
let C = new Champ(P.X, T.X, proba);


document.addEventListener('DOMContentLoaded', startGame);
document.addEventListener('keydown', gererClavier);


