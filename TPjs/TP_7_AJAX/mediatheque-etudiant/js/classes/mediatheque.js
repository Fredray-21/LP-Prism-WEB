class Mediatheque {

    constructor() {
        this.tabLivres = [];
        this.tabAdherents = [];

    }

    getLivreByNumLivre(numL) {
        return this.tabLivres.find((livre) => {
            return livre.numLivre === numL;
        });
    }

    getAdherentByNumAdherent(numAdh) {
        return this.tabAdherents.find((adherent) => {
            return adherent.numAdherent === numAdh;
        });
    }

    ajouteLivre(livre) {
        this.tabLivres.push(livre);
    }

    ajouteAdherent(adherent) {
        this.tabAdherents.push(adherent);
    }

    supprimeAdherent(adherent) {
        const index = this.tabAdherents.indexOf(adherent);
        if (index > -1) {
            this.tabAdherents.splice(index, 1);
        }
    }

    supprimeLivre(livre) {
        const index = this.tabLivres.indexOf(livre);
        if (index > -1) {
            this.tabLivres.splice(index, 1);
        }
    }

    prete(livre, adherent) {
        livre.numEmprunteur = adherent.numAdherent;
        livre.estEmprunte = 1;
        adherent.emprunte(livre);
    }

    recupere(livre) {
        const adherent = this.getAdherentByNumAdherent(livre.numEmprunteur);
        livre.numEmprunteur = null;
        livre.estEmprunte = "0";
        adherent.retourne(livre);
    }

    insererLivres(tabL) {
        tabL.forEach((livre) => {
            this.ajouteLivre(livre);
        });
    }

    insererAdherents(tabA) {
        tabA.forEach((adherent) => {
            this.ajouteAdherent(adherent);
        });
    }

    insererEmprunts(tabL) {
        tabL.forEach((livre) => {
            if (livre.numEmprunteur != null & !isNaN(livre.numEmprunteur)) {
                const adherent = this.getAdherentByNumAdherent(livre.numEmprunteur);
                this.prete(livre, adherent);
            }
        });
    }
}
