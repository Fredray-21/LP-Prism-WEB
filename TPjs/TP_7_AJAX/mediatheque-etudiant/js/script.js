// variables javascript liées à l'interface HTML
let enrAdh = document.querySelector('#enregistrerAdherent');
let inpNomAdh = document.querySelector('#nomAdherent');
let inpPreAdh = document.querySelector('#prenomAdherent');
let inpNumAdherent = document.querySelector('#numAdherent');

let enrLivre = document.querySelector('#enregistrerLivre');
let inpTitre = document.querySelector('#titreLivre');
let inpAuteur = document.querySelector('#auteurLivre');
let inpNumLivre = document.querySelector('#numLivre');

let divBoutons = document.querySelector('#boutons');
let boutonRecharger = document.getElementById('recharger');
let boutonSauvegarder = document.getElementById('sauvegarder');

let divlisteAdh = document.getElementById('listeAdherents');
let divlisteLivresDispos = document.getElementById('listeLivresDisponibles');
let divlisteLivresEmpruntes = document.getElementById('listeLivresEmpruntes');

let inpMenuADH = document.querySelector('#menuADH');
let inpMenuLIVRE = document.querySelector('#menuLIVRE');

let divAdh = document.getElementById('adh');
let divLivresDispos = document.getElementById('dispos');
let divLivresEmpruntes = document.getElementById('empr');

let divAjoutAdherent = document.getElementById('ajoutAdherent');
let divAjoutLivre = document.getElementById('ajoutLivre');

let inpPrint = document.getElementById("print");

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
function afficherAdherents(divlisteAdh) {
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

        divButton = createButtonEvent();
        divButton.dataset.numAdherent = adherent.numAdherent;

        div.appendChild(li);
        div.appendChild(divButton);
        divlisteAdh.appendChild(div);
        divlisteAdh.parentElement.querySelector("legend").innerHTML = "Liste des adhérents (" + M.tabAdherents.length + ")";
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

        divButton = createButtonEvent();
        divButton.dataset.numLivre = livre.numLivre;

        div.appendChild(li);
        div.appendChild(divButton);
        if (livre.estEmprunte == 0) {
            divlisteLivresDispos.appendChild(div);
        } else {
            divlisteLivresEmpruntes.appendChild(div);
        }
        divlisteLivresEmpruntes.parentElement.querySelector("legend").innerHTML = "Livres empruntés";
    });
}

function createButtonEvent() {
    const buttonEdit = document.createElement('button');
    buttonEdit.textContent = "Modifier";

    const buttonDel = document.createElement('button');
    buttonDel.textContent = "Supprimer";

    const divButton = document.createElement("div");
    divButton.appendChild(buttonEdit);
    divButton.appendChild(buttonDel);
    divButton.style.margin = "0";
    return divButton;
}

function createButtonCancel(divAjout) {
    // if buttonCancel doesn't exist, we create it
    if (!document.getElementById("buttonCancel")) {
        const buttonCancel = document.createElement("input");
        buttonCancel.value = "Annuler";
        buttonCancel.type = "button";
        buttonCancel.style.margin = "0 0 0 10px";
        buttonCancel.style.width = "100px";
        buttonCancel.id = "buttonCancel";
        buttonCancel.addEventListener("click", () => {
            divAjout.querySelector("legend").innerHTML = divAjout.id == "divAjoutAdherent" ? "Nouvel adhérent" : "Nouveau livre";
            divAjout.querySelector("div").removeChild(buttonCancel);
            inpNomAdh.value = "";
            inpPreAdh.value = "";
            inpNumAdherent.value = "";
            inpNumLivre.value = "";
            inpTitre.value = "";
            inpAuteur.value = "";
            enrAdh.value = "Enregistrer";
            enrLivre.value = "Enregistrer";
            alert("Modification annulée");
        });
        divAjout.querySelector("div").appendChild(buttonCancel);
    }
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

        div.lastChild.firstChild.addEventListener('click', () => { // pour chaque bouton de suppression d'adhérent
            const adherent = M.getAdherentByNumAdherent(parseInt(div.lastChild.dataset.numAdherent));
            if (confirm("Voulez-vous vraiment modifier l'adhérent " + adherent.nom + " " + adherent.prenom + " ?")) {
                // on met l'adhérent de la liste des adhérents
                // et on met à jour l'affichage

                divAjoutAdherent.querySelector("legend").innerHTML = "Modification de l'adherent N°" + adherent.numAdherent;
                createButtonCancel(divAjoutAdherent);

                inpNomAdh.value = adherent.nom;
                inpPreAdh.value = adherent.prenom;
                inpNumAdherent.value = adherent.numAdherent;
                enrAdh.value = "Valider Modification";
            }
        });

        div.lastChild.lastChild.addEventListener('click', () => { // pour chaque bouton de suppression d'adhérent
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
            const numAdherent = prompt("A quel adhérent souhaitez-vous prêter ce livre ?\nIndiquez son numéro d'adhérent\n\n" + M.listeAdherent() + "");
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


        div.draggable = true;
        div.addEventListener("dragstart", e => {
            afficherAdherents(divlisteLivresEmpruntes);
            const listeAdherents = document.querySelector("#empr  #listeLivresEmpruntes");
            const numLivre = parseInt(div.lastChild.dataset.numLivre);
            listeAdherents.childNodes.forEach(div => {
                div.draggable = true;
                div.addEventListener("dragover", e => {
                    e.preventDefault();
                });
                div.addEventListener("drop", e => {
                    e.preventDefault();
                    const numAdherent = parseInt(div.lastChild.dataset.numAdherent);
                    const adherent = M.getAdherentByNumAdherent(numAdherent);
                    const livre = M.getLivreByNumLivre(numLivre);
                    if (confirm("Voulez-vous vraiment prêter le livre \"" + livre.titre + "\" \nà l'adhérent " + adherent.nom + " " + adherent.prenom + " ?")) {
                        M.prete(livre, adherent);
                        MAJ();
                        alert("Le livre a bien été prêté à l'adhréent N°" + numAdherent + "");
                        boutonSauvegarder.style.backgroundColor = "red";
                    }
                });
            });
        });
        eventsButtonLivre(div);
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
            if (confirm("Voulez-vous vraiment rendre le livre " + livre.titre + " ?")) {
                // on récupère le livre de la liste des livres
                // et on met à jour l'affichage
                M.recupere(livre);
                MAJ();
                alert(`Le livre ${livre.titre} a bien été rendu`);
                boutonSauvegarder.style.backgroundColor = "red";
            }
        });
        eventsButtonLivre(div);
    });
}

function eventsButtonLivre(div) {
    div.lastChild.firstChild.addEventListener('click', () => { // pour chaque bouton de modification de livre
        const numLivre = parseInt(div.lastChild.dataset.numLivre);
        const livre = M.getLivreByNumLivre(numLivre);
        if (confirm("Voulez-vous vraiment modifier le livre " + livre.titre + " ?")) {
            // on modifie le livre de la liste des livres
            // et on met à jour l'affichage

            divAjoutLivre.querySelector("legend").innerHTML = "Modification du livre N°" + livre.numLivre;
            createButtonCancel(divAjoutLivre);

            inpTitre.value = livre.titre;
            inpAuteur.value = livre.auteur;
            inpNumLivre.value = livre.numLivre;
            enrLivre.value = "Valider Modification";
        }
    });

    div.lastChild.lastChild.addEventListener('click', () => { // pour chaque bouton de suppression de livre
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
}


function MAJ() {
    // on affiche les adhérents, on affiche les livres,
    // et on lance les fonctions de gestion des divers événements click
    afficherLivres();
    afficherAdherents(divlisteAdh);
    eventsAdherents();
    eventsLivresDispos();
    eventsLivresEmpruntes();
}


// écouteurs d'événements permanents
window.addEventListener("load", chargerDonneesAJAX);


boutonSauvegarder.addEventListener('click', () => {
    // après confirmation, on redonne son style initial au bouton de sauvegarde,
    // puis on lance la sauvegarde
    if (confirm("Voulez-vous vraiment mettre à jour la source de données ?")) {
        sauvegardeMySQL();
    }
});

boutonRecharger.addEventListener('click', () => {
    // après confirmation, on recharge la page par location.reload()
    if (confirm("Vous vous apprêtez à recharger les données.\nCela implique que les changements non enregistrés seront définitivement perdus.\n\nConfirmez-vous le rechargement des données?")) {
        location.reload();
    }
});

enrLivre.addEventListener('click', () => {
    // si les deux imput sont bien remplis,
    // alors on ajoute le livre à la médiathèque.
    // conseil : au moment de créer le nouveau livre (qui sera bien entendu pas encore emprunté),
    // s'arranger pour que son numLivre dépasse d'une unité le max des numLivre existants.
    // ensuite, on adapte le style du bouton de sauvegarde, on efface le contenu des
    // deux input de saisie et on met à jour la médiathèque

    if (inpTitre.value == "" || inpAuteur.value == "") {
        alert("Veuillez remplir tous les champs");
    } else {
        if (enrLivre.value == "Valider Modification") {
            M.modifierLivre(inpNumLivre.value, inpTitre.value, inpAuteur.value);
            MAJ();
            boutonSauvegarder.style.backgroundColor = "red";
            inpTitre.value = "";
            inpAuteur.value = "";
            enrLivre.value = "Enregistrer";
            divAjoutLivre.querySelector("legend").innerHTML = "Nouveau livre";
            alert(`Le livre N° ${inpNumLivre.value} a bien été modifié !`);
            document.getElementById("buttonCancel").remove();
        } else {
            const NewNumLivre = M.tabLivres.reduce((acc, livre) => livre.numLivre > acc ? livre.numLivre : acc, 0) + 1;
            M.ajouteLivre(new Livre(NewNumLivre, inpTitre.value, inpAuteur.value, null, 0));
            MAJ();
            boutonSauvegarder.style.backgroundColor = "red";
            inpTitre.value = "";
            inpAuteur.value = "";
            alert("Le livre a bien été ajouté !");
        }
    }
});

enrAdh.addEventListener('click', () => {
    // si les deux imput sont bien remplis,
    // alors on ajoute l'adhérent à la médiathèque.
    // conseil : au moment de créer le nouvel adhérent,
    // s'arranger pour que son numAdherent dépasse d'une unité le max des numAdherent existants.
    // ensuite, on adapte le style du bouton de sauvegarde, on efface le contenu des
    // deux input de saisie et on met à jour la médiathèque

    if (inpNomAdh.value == "" || inpPreAdh.value == "") {
        alert("Veuillez remplir tous les champs");
    } else {
        if (enrAdh.value == "Valider Modification") {
            M.modifierAdherent(inpNumAdherent.value, inpNomAdh.value, inpPreAdh.value);
            MAJ();
            boutonSauvegarder.style.backgroundColor = "red";
            inpNomAdh.value = "";
            inpPreAdh.value = "";
            enrAdh.value = "Enregistrer";
            divAjoutAdherent.querySelector("legend").innerHTML = "Nouvel adhérent";
            alert(`L'adhérent N° ${inpNumAdherent.value} a bien été modifié !`);
            document.getElementById("buttonCancel").remove();
        } else {
            const NewNumAdh = M.tabAdherents.reduce((acc, adherent) => adherent.numAdherent > acc ? adherent.numAdherent : acc, 0) + 1;
            M.ajouteAdherent(new Adherent(NewNumAdh, inpNomAdh.value, inpPreAdh.value));
            MAJ();
            boutonSauvegarder.style.backgroundColor = "red";
            inpNomAdh.value = "";
            inpPreAdh.value = "";
            alert("L'adhérent a bien été ajouté !");
        }
    }
});

inpMenuADH.addEventListener("click", () => {
    divLivresDispos.style.display = "none";
    divLivresEmpruntes.style.display = "none";
    divAdh.style.display = "block";
    inpMenuADH.style.textDecoration = "underline";
    inpMenuLIVRE.style.textDecoration = "none";
    divAjoutLivre.style.display = "none";
    divAjoutAdherent.style.display = "flex";
});

inpMenuLIVRE.addEventListener("click", () => {
    divAdh.style.display = "none";
    divLivresDispos.style.display = "block";
    divLivresEmpruntes.style.display = "block";
    inpMenuLIVRE.style.textDecoration = "underline";
    inpMenuADH.style.textDecoration = "none";
    divAjoutAdherent.style.display = "none";
    divAjoutLivre.style.display = "flex";
});

inpPrint.addEventListener("click", () => {
    // on imprime la médiathèque
    console.log(M);
    window.print();
});

