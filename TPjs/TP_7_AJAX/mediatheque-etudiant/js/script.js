// variables javascript liées à l'interface HTML
let enrAdh = document.querySelector('#enregistrerAdherent');
let inpNomAdh = document.querySelector('#nomAdherent');
let inpPreAdh = document.querySelector('#prenomAdherent');

let enrLivre = document.querySelector('#enregistrerLivre');
let inpTitre = document.querySelector('#titreLivre');
let inpAuteur = document.querySelector('#auteurLivre');

let divBoutons = document.querySelector('#boutons');
let boutonRecharger = document.getElementById('recharger');
let boutonSauvegarder = document.getElementById('sauvegarder');

let divlisteAdh = document.getElementById('listeAdherents');
let divlisteLivresDispos = document.getElementById('listeLivresDisponibles');
let divlisteLivresEmpruntes = document.getElementById('listeLivresEmpruntes');

// création de la médiathèque
let M = new Mediatheque();

// méthodes utiles internes
function vide(div) {
    // vide de toutes ses balises la div
    // passée en paramètre
    div.innerHTML = "";
}

function videM() {
    // vide les 3 colonnes de l'interface (adhérents, livres dispos et livres empruntés)
    // et réinitialise les tableaux tabLivres et tabAdherents de la médiathèque M
    vide(divlisteAdh);
    vide(divlisteLivresDispos);
    vide(divlisteLivresEmpruntes);
    M.tabLivres = [];
    M.tabAdherents = [];
}

// méthode de chargement des données
function chargerDonneesAJAX() {
    // vide la médiathèque,
    // puis charge par un objet XMLHttpRequest les données de la base : adhérents et livres.
    // une fois les données chargées, on remplit les colonnes de la médiathèque
    // grâce aux méthodes insererLivres, insererAdherents et insererEmprunts
    // enfin, on met à jour la médiathèque
    videM();
    const xhr = new XMLHttpRequest();
    const url = "./php/routeur.php?objet=mediatheque&action=chargerDonneesMySQL";
    xhr.open("GET", url, true);
    xhr.onload = () => callback(xhr);
    xhr.send();

    callback = (xhr) => {
        if (xhr.status === 200) {
            let [tabLivres, tabAdherents] = JSON.parse(xhr.responseText);
            tabLivres = tabLivres.map(livre => new Livre(parseInt(livre.numLivre), livre.titre, livre.auteur, parseInt(livre.numEmprunteur), livre.estEmprunte));
            M.insererLivres(tabLivres);
            M.insererAdherents(tabAdherents.map(adherent => new Adherent(parseInt(adherent.numAdherent), adherent.nom, adherent.prenom)));
            M.insererEmprunts(tabLivres);
            MAJ();
        }
    }
}

// méthode de sauvegarde des données
function sauvegardeMySQL() {
    // on initialise deux objets XMLHttpRequest
    // le premier va mettre à jour les adhérents en appelant MAJadherents.php,
    // et en passant en paramètre dans l'url la chaîne correspondant au tableau des adhérents
    // le deuxième va mettre à jour les livres en appelant MAJemprunteurs.php,
    // et en passant en paramètre dans l'url la chaîne correspondant au tableau des livres
    // enfin, on redonne au bouton de sauvegarde son aspect initial
    const xhr1 = new XMLHttpRequest();
    const url1 = "./php/routeur.php?objet=adherent&action=MAJadherents&tabAdherents=" + JSON.stringify(M.tabAdherents);
    xhr1.open("GET", url1, true);
    xhr1.onload = () => callback();
    xhr1.send();


    callback = () => { // pour vérifier que la première requête a bien été exécutée
        if (xhr1.status === 200) {
            const xhr2 = new XMLHttpRequest();
            const url2 = "./php/routeur.php?objet=livre&action=MAJemprunteurs&tabLivres=" + JSON.stringify(M.tabLivres);
            xhr2.open("GET", url2, true);
            xhr2.onload = () => callback2(xhr2);
            xhr2.send();
        }
    }
    callback2 = (xhr2) => { // pour vérifier que les deux requêtes ont bien été exécutées
        if (xhr2.status === 200) {
            boutonSauvegarder.style.backgroundColor = "#E1E1E1";
            alert("Les données ont bien été sauvegardées");
        }
    }
}


// méthodes d'affichage et mise à jour de l'interface
function afficherAdherents() {
    // on commence par vider la div des adhérents
    // ensuite, on la reconstruit élément par élément
    // en insérant entre parenthèses le nombre d'emprunts
    // si l'adhérent a des emprunts)

    vide(divlisteAdh);
    M.tabAdherents.forEach(adherent => {
        const div = document.createElement('div');
        let li = document.createElement('li');
        li.textContent = adherent.numAdherent + "-" + adherent.nom + " " + adherent.prenom;

        if (adherent.tabEmprunts.length > 0) {
            li.textContent += " (" + adherent.tabEmprunts.length + " emprunt)";
        }

        const button = document.createElement('button');
        button.textContent = "Supprimer";
        button.dataset.numAdherent = adherent.numAdherent;
        div.appendChild(li);
        div.appendChild(button);
        divlisteAdh.appendChild(div);
    });
}

function afficherLivres() {
    // on commence par vider les div des livres dispos et des livres empruntés
    // ensuite, on les reconstruit élément par élément
    // en insérant le livre dans l'une ou dans l'autre selon qu'il est emprunté ou non

    vide(divlisteLivresDispos);
    vide(divlisteLivresEmpruntes);
    M.tabLivres.forEach(livre => {
        const div = document.createElement('div');
        let li = document.createElement('li');
        li.textContent = livre.numLivre + "-" + livre.titre + " (" + livre.auteur + ")";

        const button = document.createElement('button');
        button.textContent = "Supprimer";
        button.dataset.numLivre = livre.numLivre;
        div.appendChild(li);
        div.appendChild(button);
        if (livre.estEmprunte == 0) {
            divlisteLivresDispos.appendChild(div);
        } else {
            divlisteLivresEmpruntes.appendChild(div);
        }
    });

}

// méthodes de gestion des événements liés aux items des listes
function eventsAdherents() {
    // pour chaque adhérent de la div, on ajoute un écouteur d'événement click
    // qui permet d'afficher la liste d'emprunts de l'adhérent (méthode listeEmprunts())

    divlisteAdh.childNodes.forEach((div, i) => {
        div.addEventListener('mouseover', () => {
            div.lastChild.style.display = "block";
        });
        div.addEventListener('mouseout', () => {
            div.lastChild.style.display = "none";
        });

        div.firstChild.addEventListener('click', () => {
            const nameString = M.tabAdherents[i].nom + " " + M.tabAdherents[i].prenom;
            const nbEmprunts = M.tabAdherents[i].tabEmprunts.length;
            if (nbEmprunts === 0) {
                alert(nameString + " n'a aucun emprunt en ce moment");
                return;
            }
            let stringlisteEmprunts = M.tabAdherents[i].listeEmprunts();
            alert(`${nameString} a emprunté ${nbEmprunts} Livre en ce moment :\n\n${stringlisteEmprunts}`);
        });

        div.lastChild.addEventListener('click', () => { // pour chaque bouton de suppression d'adhérent
            const adherent = M.getAdherentByNumAdherent(parseInt(div.lastChild.dataset.numAdherent));
            if (confirm("Voulez-vous vraiment supprimer l'adhérent " + adherent.nom + " " + adherent.prenom + " ?")) {
                // on supprime l'adhérent de la liste des adhérents
                // et on met à jour l'affichage
                M.supprimeAdherent(adherent);
                MAJ();
                alert(`L'adhérent ${adherent.nom} ${adherent.prenom} a bien été supprimé`);
                boutonSauvegarder.style.backgroundColor = "red";
            }
        });
    });
}

function eventsLivresDispos() {
    // pour chaque livre dispo, on ajoute un écouteur d'événement click
    // qui demande à quel adhérent on prête le livre.
    // ensuite, on prête le livre à l'adhérent,
    // et on change le style du bouton de sauvegarde pour prévenir
    // l'utilisateur que des changements sont intervenus.
    // Idéalement, prévoir de tester le numAdhérent entré pour qu'il soit valide.

    divlisteLivresDispos.childNodes.forEach(div => {
        div.addEventListener('mouseover', () => {
            div.lastChild.style.display = "block";
        });
        div.addEventListener('mouseout', () => {
            div.lastChild.style.display = "none";
        });

        div.firstChild.addEventListener('click', () => {
            let adherent = null;
            const numAdherent = prompt("A quel adhérent souhaitez-vous prêter ce livre ?\nIndiquez son numéro d'adhérent");
            adherent = M.getAdherentByNumAdherent(parseInt(numAdherent)) || null;
            if (adherent === null) {
                alert("L'adhérent n'existe pas");
                return;
            }

            const numLivre = parseInt(div.firstChild.textContent.split("-")[0]);
            const livre = M.getLivreByNumLivre(numLivre);
            M.prete(livre, adherent)
            MAJ();
            alert("Le livre a bien été prêté à l'adhréent N°" + numAdherent + "");
            boutonSauvegarder.style.backgroundColor = "red";
        });

        div.lastChild.addEventListener('click', () => { // pour chaque bouton de suppression de livre
            const numLivre = parseInt(div.lastChild.dataset.numLivre);
            const livre = M.getLivreByNumLivre(numLivre);
            if (confirm("Voulez-vous vraiment supprimer le livre " + livre.titre + " ?")) {
                // on supprime le livre de la liste des livres
                // et on met à jour l'affichage
                M.recupere(livre);
                M.supprimeLivre(livre);
                MAJ();
                alert(`Le livre ${livre.titre} a bien été supprimé`);
                boutonSauvegarder.style.backgroundColor = "red";
            }
        });
    });
}

function eventsLivresEmpruntes() {
    // pour chaque livre emprunté, on ajoute un écouteur d'événement click
    // qui demande confirmation du retour du livre.
    // ce retour implique que la médiathèque récupère le livre,
    // et qu'on met à jour la médiathèque.
    // Ne pas oublier le changement de style du bouton de sauvegarde.

    divlisteLivresEmpruntes.childNodes.forEach(div => {
        div.addEventListener('mouseover', () => {
            div.lastChild.style.display = "block";
        });
        div.addEventListener('mouseout', () => {
            div.lastChild.style.display = "none";
        });

        div.firstChild.addEventListener('click', () => {
            const numLivre = parseInt(div.firstChild.textContent.split("-")[0]);
            const livre = M.getLivreByNumLivre(numLivre);
            const adherent = M.getAdherentByNumAdherent(livre.numEmprunteur);
            if (confirm(`Livre prêté à ${adherent.nom} ${adherent.prenom}\nVoulez-vous retourner ce livre ?`)) {
                M.recupere(livre);
                MAJ();
                alert("Le livre a bien été retourné !");
                boutonSauvegarder.style.backgroundColor = "red";
            }
        });

        div.lastChild.addEventListener('click', () => { // pour chaque bouton de suppression de livre
            const numLivre = parseInt(div.lastChild.dataset.numLivre);
            const livre = M.getLivreByNumLivre(numLivre);
            if (confirm("Voulez-vous vraiment supprimer le livre " + livre.titre + " ?")) {
                // on supprime le livre de la liste des livres
                // et on met à jour l'affichage
                M.recupere(livre);
                M.supprimeLivre(livre);
                MAJ();
                alert(`Le livre ${livre.titre} a bien été supprimé`);
                boutonSauvegarder.style.backgroundColor = "red";
            }
        });
    });
}


function MAJ() {
    // on affiche les adhérents, on affiche les livres,
    // et on lance les fonctions de gestion des divers événements click
    afficherLivres();
    afficherAdherents();
    eventsAdherents();
    eventsLivresDispos();
    eventsLivresEmpruntes();
}


// écouteurs d'événements permanents
window.addEventListener("load", chargerDonneesAJAX);


boutonSauvegarder.addEventListener('click', function () {
    // après confirmation, on redonne son style initial au bouton de sauvegarde,
    // puis on lance la sauvegarde
    if (confirm("Voulez-vous vraiment mettre à jour la source de données ?")) {
        sauvegardeMySQL();
    }
});

boutonRecharger.addEventListener('click', function () {
    // après confirmation, on recharge la page par location.reload()
    if (confirm("Vous vous apprêtez à recharger les données.\nCela implique que les changements non enregistrés seront définitivement perdus.\n\nConfirmez-vous le rechargement des données?")) {
        location.reload();
    }
});

enrLivre.addEventListener('click', function () {
    // si les deux imput sont bien remplis,
    // alors on ajoute le livre à la médiathèque.
    // conseil : au moment de créer le nouveau livre (qui sera bien entendu pas encore emprunté),
    // s'arranger pour que son numLivre dépasse d'une unité le max des numLivre existants.
    // ensuite, on adapte le style du bouton de sauvegarde, on efface le contenu des
    // deux input de saisie et on met à jour la médiathèque

    if (inpTitre.value == "" || inpAuteur.value == "") {
        alert("Veuillez remplir tous les champs");
    } else {
        const NewNumLivre = M.tabLivres.reduce((acc, livre) => livre.numLivre > acc ? livre.numLivre : acc, 0) + 1;
        M.ajouteLivre(new Livre(NewNumLivre, inpTitre.value, inpAuteur.value, null, 0));
        MAJ();
        boutonSauvegarder.style.backgroundColor = "red";
        inpTitre.value = "";
        inpAuteur.value = "";
        alert("Le livre a bien été ajouté !");

    }
});

enrAdh.addEventListener('click', function () {
    // si les deux imput sont bien remplis,
    // alors on ajoute l'adhérent à la médiathèque.
    // conseil : au moment de créer le nouvel adhérent,
    // s'arranger pour que son numAdherent dépasse d'une unité le max des numAdherent existants.
    // ensuite, on adapte le style du bouton de sauvegarde, on efface le contenu des
    // deux input de saisie et on met à jour la médiathèque

    if (inpNomAdh.value == "" || inpPreAdh.value == "") {
        alert("Veuillez remplir tous les champs");
    } else {
        const NewNumAdh = M.tabAdherents.reduce((acc, adherent) => adherent.numAdherent > acc ? adherent.numAdherent : acc, 0) + 1;
        M.ajouteAdherent(new Adherent(NewNumAdh, inpNomAdh.value, inpPreAdh.value));
        MAJ();
        boutonSauvegarder.style.backgroundColor = "red";
        inpNomAdh.value = "";
        inpPreAdh.value = "";
        alert("L'adhérent a bien été ajouté !");
    }
});
