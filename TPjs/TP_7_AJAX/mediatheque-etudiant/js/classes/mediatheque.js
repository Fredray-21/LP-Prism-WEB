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

    modifierAdherent(numADH, nom, prenom) {
        const adherent = this.getAdherentByNumAdherent(parseInt(numADH));
        console.log(adherent);
        adherent.nom = nom;
        adherent.prenom = prenom;
    }

    modifierLivre(numL, titre, auteur) {
        const livre = this.getLivreByNumLivre(parseInt(numL));
        console.log(livre);
        livre.titre = titre;
        livre.auteur = auteur;
    }


    prete(livre, adherent) {
        livre.numEmprunteur = adherent.numAdherent;
        livre.estEmprunte = 1;
        adherent.emprunte(livre);
    }

    recupere(livre) {
        if (livre.estEmprunte == "0") return;
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

    listeAdherent() {
        let liste = "";
        this.tabAdherents.forEach(adherent => {
            liste += adherent.numAdherent + "- " + adherent.nom + " " + adherent.prenom + "\n";
        });
        return liste;
    }
}
