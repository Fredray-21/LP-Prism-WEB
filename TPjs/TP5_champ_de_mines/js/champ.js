class Champ {

    constructor(xP, xT, proba) {
        this.carte = Array.from(Array(20), () => Array.from(Array(20), () => Math.random() < proba ? 1 : 0));
        xP - 1 >= 0 ? this.carte[xP - 1][18] = 0 : null;
        xP - 2 >= 0 ? this.carte[xP - 2][18] = 0 : null;
        xP - 2 >= 0 ? this.carte[xP - 2][19] = 0 : null;
        xP < 19 ? this.carte[xP][18] = 0 : null;
        xP < 19 ? this.carte[xP][19] = 0 : null;
        xT < 19 ? this.carte[xT][0] = 0 : null;
        xT < 19 ? this.carte[xT][1] = 0 : null;
        xT - 1 >= 0 ? this.carte[xT - 1][1] = 0 : null;
        xT - 2 >= 0 ? this.carte[xT - 2][1] = 0 : null;
        xT - 2 >= 0 ? this.carte[xT - 2][0] = 0 : null;

        this.carte[xP - 1][20 - 1] = P;
        this.carte[xT - 1][1 - 1] = T;

        // remove mine autour de la position du joueur et de la position du trésor
        console.table(this.carte);
        this.generateImgMines();
    }

    generateImgMines() {
        this.carte.forEach((ligne, y) => {
            ligne.forEach((colonne, x) => {
                if (colonne == 1) {
                    let img = document.createElement("img");
                    img.setAttribute("src", "img/croix.png");
                    img.width = 20;
                    img.height = 20;
                    img.style.position = "absolute";
                    img.style.top = 49.5 + (20 * (x)) + "px";
                    img.style.left = 49 + (20 * (y)) + "px";
                    img.classList.add("mine");
                    img.classList.add("cachee");
                    document.getElementById("carte").appendChild(img);
                }
            });
        });
    }

    toogleMine() {
        Array.from(document.getElementsByClassName("mine")).forEach(mine => mine.classList.toggle("cachee"));
        setTimeout(() => {
            Array.from(document.getElementsByClassName("mine")).forEach(mine => mine.classList.toggle("cachee"));
        }, 500);
    }
}
