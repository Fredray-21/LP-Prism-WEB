class Personnage extends Element {

    constructor(x) {
        super(x, 20, 'personnage');
    }

    initialiser(x) {
        super.initialiser(x, 1, 'img/personnage.png');
    }

    mouvement(dx, dy) {
        this.X + dx >= 1 && this.X + dx <= 20 ? this.X += dx : this.X;
        this.Y + dy >= 1 && this.Y + dy <= 20 ? this.Y += dy : this.Y;

        P.placer();
    }


    indiquer_situation(C) {
        // à compléter
    }

    trouve(T) {
        if (this.X == T.X && this.Y == T.Y) {
            alert("Vous avez trouvé le trésor !");
            return true;
        }
        return false;
    }

    explose(C) {
        if (C.carte[this.X - 1][this.Y] == 1) {
            alert("Vous avez EXPLOOOOOOSEDDD !");
            return true;
        }
        return false;
    }

    nbProxMines(C) {
        // à compléter
    }

}
