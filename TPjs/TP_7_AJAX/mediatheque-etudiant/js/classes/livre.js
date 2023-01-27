class Livre {

    constructor(numLivre, titre, auteur, numEmprunteur, estEmprunte) {
        this.numLivre = numLivre;
        this.titre = titre;
        this.auteur = auteur;
        this.numEmprunteur = numEmprunteur;
        this.estEmprunte = estEmprunte;
    }

    toString() {
        return `Livre[numLivre = ${this.numLivre}, titre = ${this.titre}, auteur = ${this.auteur}, numEmprunteur = ${this.numEmprunteur}, estEmprunte = ${this.estEmprunte}]`;
    }
}
