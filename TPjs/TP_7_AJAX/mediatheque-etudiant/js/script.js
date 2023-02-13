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
            showModal("Les données ont bien été sauvegardées", "alert");
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
        const img = document.createElement('img');
        img.src = "./img/icon_person.svg";
        img.alt = "icône d'un homme";

        li.textContent = adherent.nom + " " + adherent.prenom;
        if (adherent.tabEmprunts.length > 0) {
            const span = document.createElement('span');
            span.textContent = " (" + adherent.tabEmprunts.length + " emprunt)";
            span.prepend(img);
            li.prepend(span);
        }else{
            li.prepend(img);
        }
        


        divButton = createButtonEvent();
        div.appendChild(li);
        div.appendChild(divButton);
        divlisteAdh.appendChild(div);
        div.dataset.numAdherent = adherent.numAdherent;
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
        const img = document.createElement('img');
        img.src = "./img/icon_book.svg";
        img.alt = "icône d'un homme";
        li.textContent = livre.titre + " (" + livre.auteur + ")";
        li.prepend(img);

        divButton = createButtonEvent();
        divButton.dataset.numLivre = livre.numLivre;

        div.appendChild(li);
        div.appendChild(divButton);
        if (livre.estEmprunte == 0) {
            divlisteLivresDispos.appendChild(div);
        } else {
            divlisteLivresEmpruntes.appendChild(div);
        }
        div.dataset.numLivre = livre.numLivre;
        divlisteLivresDispos.parentElement.querySelector("legend").innerHTML = "Livres disponibles " + "(" + M.tabLivres.filter(livre => livre.estEmprunte == 0).length + ")";
        divlisteLivresEmpruntes.parentElement.querySelector("legend").innerHTML = "Livres empruntés" + "(" + M.tabLivres.filter(livre => livre.estEmprunte == 1).length + ")";
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
            showModal("Modification annulée", "alert");
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
                showModal("<b>"+nameString + "</b> n'a aucun emprunt en ce moment", "alert");
                return;
            }
            showModal("Liste des emprunts de <b>" + nameString+"</b>", "afficherListe", null, null, M.tabAdherents[i].tabEmprunts);

        });

        div.lastChild.firstChild.addEventListener('click', () => { // pour chaque bouton de suppression d'adhérent
            const adherent = M.getAdherentByNumAdherent(parseInt(div.dataset.numAdherent));

            showModal("Voulez-vous vraiment modifier l'adhérent <b>" + adherent.nom + " " + adherent.prenom + "</b> ?", "confirm", () => {
                // on met dans la div de modification l'adhérent de la liste des adhérents
                // et on met à jour l'affichage
                divAjoutAdherent.querySelector("legend").innerHTML = "Modification de l'adherent";
                createButtonCancel(divAjoutAdherent);

                inpNomAdh.value = adherent.nom;
                inpPreAdh.value = adherent.prenom;
                inpNumAdherent.value = adherent.numAdherent;
                enrAdh.value = "Valider Modification";
            });

        });

        div.lastChild.lastChild.addEventListener('click', () => { // pour chaque bouton de suppression d'adhérent
            const adherent = M.getAdherentByNumAdherent(parseInt(div.dataset.numAdherent));

            showModal("Voulez-vous vraiment supprimer l'adhérent <b>" + adherent.nom + " " + adherent.prenom + "</b> ?", "confirm", () => {
                // on supprime l'adhérent de la liste des adhérents
                // et on met à jour l'affichage
                M.supprimeAdherent(adherent);
                MAJ();
                showModal(`L'adhérent <b>${adherent.nom} ${adherent.prenom}</b> a bien été supprimé`, "alert");
                boutonSauvegarder.style.backgroundColor = "red";
            });
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
            showModal("A quel adhérent souhaitez-vous prêter ce livre ?", "prompt", (numAdherent) => {
                adherent = M.getAdherentByNumAdherent(parseInt(numAdherent)) || null;
                if (adherent === null) {
                    showModal("L'adhérent n'existe pas", "alert");
                    return;
                } else {
                    const numLivre = parseInt(div.dataset.numLivre);
                    const livre = M.getLivreByNumLivre(numLivre);
                    M.prete(livre, adherent)
                    boutonSauvegarder.style.backgroundColor = "red";
                    MAJ();
                    showModal(`Le livre <b>${livre.titre}</b> a bien été prêté à <b>${adherent.nom} ${adherent.prenom}</b>`, "alert");
                }
            });
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
                    const numAdherent = parseInt(div.dataset.numAdherent);
                    const adherent = M.getAdherentByNumAdherent(numAdherent);
                    const livre = M.getLivreByNumLivre(numLivre);

                    showModal("Voulez-vous vraiment prêter le livre <br>\"" + livre.titre + "\"<br>à l'adhérent <b>" + adherent.nom + " " + adherent.prenom + "</b> ?", "confirm", () => {
                        M.prete(livre, adherent);
                        MAJ();
                        showModal(`Le livre <b>${livre.titre}</b> a bien été prêté à <b>${adherent.nom} ${adherent.prenom}</b>`, "alert");
                        boutonSauvegarder.style.backgroundColor = "red";
                    });
                });
            });
            div.addEventListener("dragend", e => {
                e.preventDefault();
                MAJ();
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
            const numLivre = parseInt(div.dataset.numLivre);
            const livre = M.getLivreByNumLivre(numLivre);
            showModal("Voulez-vous vraiment rendre le livre <b>\"" + livre.titre + "\"</b> ?", "confirm", () => {
                M.recupere(livre);
                MAJ();
                showModal("Le livre a bien été rendu", "alert");
                boutonSauvegarder.style.backgroundColor = "red";
            });
        });
        eventsButtonLivre(div);
    });
}

function eventsButtonLivre(div) {
    div.lastChild.firstChild.addEventListener('click', () => { // pour chaque bouton de modification de livre
        const numLivre = parseInt(div.lastChild.dataset.numLivre);
        const livre = M.getLivreByNumLivre(numLivre);
        showModal("Voulez-vous vraiment modifier le livre <b>" + livre.titre + "</b> ?", "confirm", () => {
            divAjoutLivre.querySelector("legend").innerHTML = "Modification du livre";
            createButtonCancel(divAjoutLivre);

            inpTitre.value = livre.titre;
            inpAuteur.value = livre.auteur;
            inpNumLivre.value = livre.numLivre;
            enrLivre.value = "Valider Modification";
        });
    });

    div.lastChild.lastChild.addEventListener('click', () => { // pour chaque bouton de suppression de livre
        const numLivre = parseInt(div.lastChild.dataset.numLivre);
        const livre = M.getLivreByNumLivre(numLivre);

        showModal("Voulez-vous vraiment supprimer le livre <b>" + livre.titre + "</b> ?", "confirm", () => {
            M.recupere(livre);
            M.supprimeLivre(livre);
            MAJ();
            showModal(`Le livre <b>${livre.titre}</b> a bien été supprimé`, "alert");
            boutonSauvegarder.style.backgroundColor = "red";
        });
    });
}


function MAJ() {
    // on affiche les adhérents, on affiche les livres,
    // et on lance les fonctions de gestion des divers événements click
    afficherLivres();
    afficherAdherents(divlisteAdh); // l'argument permet de choisir la div où afficher les adhérents pour le drag and drop
    eventsAdherents();
    eventsLivresDispos();
    eventsLivresEmpruntes();
}


// écouteurs d'événements permanents
window.addEventListener("load", chargerDonneesAJAX);


boutonSauvegarder.addEventListener('click', () => {
    // après confirmation, on redonne son style initial au bouton de sauvegarde,
    // puis on lance la sauvegarde

    showModal("Voulez-vous vraiment mettre à jour la source de données ?", "confirm", () => {
        sauvegardeMySQL();
    });
});

boutonRecharger.addEventListener('click', () => {
    // après confirmation, on recharge la page par location.reload()
    showModal("Vous vous apprêtez à recharger les données.<br>Cela implique que les changements non enregistrés seront définitivement perdus.<br><br>Confirmez-vous le rechargement des données?", "confirm", () => {
        location.reload();
    });
});

enrLivre.addEventListener('click', () => {
    // si les deux imput sont bien remplis,
    // alors on ajoute le livre à la médiathèque.
    // conseil : au moment de créer le nouveau livre (qui sera bien entendu pas encore emprunté),
    // s'arranger pour que son numLivre dépasse d'une unité le max des numLivre existants.
    // ensuite, on adapte le style du bouton de sauvegarde, on efface le contenu des
    // deux input de saisie et on met à jour la médiathèque

    if (inpTitre.value == "" || inpAuteur.value == "") {
        showModal("Veuillez remplir tous les champs", "alert");
    } else {
        if (enrLivre.value == "Valider Modification") {
            M.modifierLivre(inpNumLivre.value, inpTitre.value, inpAuteur.value);
            MAJ();
            boutonSauvegarder.style.backgroundColor = "red";
            inpTitre.value = "";
            inpAuteur.value = "";
            enrLivre.value = "Enregistrer";
            divAjoutLivre.querySelector("legend").innerHTML = "Nouveau livre";
            showModal(`Le livre <b>${inpTitre.value}</b> a bien été modifié !`, "alert");

            document.getElementById("buttonCancel").remove();
        } else {
            const NewNumLivre = M.tabLivres.reduce((acc, livre) => livre.numLivre > acc ? livre.numLivre : acc, 0) + 1;
            M.ajouteLivre(new Livre(NewNumLivre, inpTitre.value, inpAuteur.value, null, 0));
            MAJ();
            boutonSauvegarder.style.backgroundColor = "red";
            inpTitre.value = "";
            inpAuteur.value = "";
            showModal("Le livre a bien été ajouté !", "alert");

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
        showModal("Veuillez remplir tous les champs", "alert");
    } else {
        if (enrAdh.value == "Valider Modification") {
            M.modifierAdherent(inpNumAdherent.value, inpNomAdh.value, inpPreAdh.value);
            MAJ();
            boutonSauvegarder.style.backgroundColor = "red";
            inpNomAdh.value = "";
            inpPreAdh.value = "";
            enrAdh.value = "Enregistrer";
            divAjoutAdherent.querySelector("legend").innerHTML = "Nouvel adhérent";
            showModal(`L'adhérent <b>${inpNomAdh.value}</b> a bien été modifié !`, "alert");
            document.getElementById("buttonCancel").remove();
        } else {
            const NewNumAdh = M.tabAdherents.reduce((acc, adherent) => adherent.numAdherent > acc ? adherent.numAdherent : acc, 0) + 1;
            M.ajouteAdherent(new Adherent(NewNumAdh, inpNomAdh.value, inpPreAdh.value));
            MAJ();
            boutonSauvegarder.style.backgroundColor = "red";
            inpNomAdh.value = "";
            inpPreAdh.value = "";
            showModal("L'adhérent a bien été ajouté !", "alert");

        }
    }
});

inpMenuADH.addEventListener("click", () => {
    divLivresDispos.style.display = "none";
    divLivresEmpruntes.style.display = "none";
    divAdh.style.display = "block";
    inpMenuADH.style.textDecoration = "underline";
    inpMenuADH.classList.toggle("active");
    inpMenuLIVRE.classList.toggle("active");
    inpMenuLIVRE.style.textDecoration = "none";
    divAjoutLivre.style.display = "none";
    divAjoutAdherent.style.display = "flex";
});

inpMenuLIVRE.addEventListener("click", () => {
    divAdh.style.display = "none";
    divLivresDispos.style.display = "block";
    divLivresEmpruntes.style.display = "block";
    inpMenuLIVRE.style.textDecoration = "underline";
    inpMenuADH.classList.toggle("active");
    inpMenuLIVRE.classList.toggle("active");
    inpMenuADH.style.textDecoration = "none";
    divAjoutAdherent.style.display = "none";
    divAjoutLivre.style.display = "flex";
});

inpPrint.addEventListener("click", () => {
    // on imprime la médiathèque
    window.print();
});


function showModal(message, type, confirmCallback, cancelCallback, listes) {
    const modal = document.getElementById('modal');
    if (typeof modal.showModal === "function") {
        if (modal.hasAttribute("open")) {
            modal.removeAttribute("open");
        }
        modal.showModal();
    } else {
        console.error("L'API <dialog> n'est pas prise en charge par ce navigateur.");
    }
    modal.querySelector("#titre_modal").innerHTML = message;
    vide(modal.querySelector("label"));

    let btnConfirm = document.getElementById("confirmBtn"); // on récupère le bouton de confirmation
    let btnCancel = document.getElementById("cancelBtn"); // on récupère le bouton d'annulation
    btnConfirm.replaceWith(btnConfirm.cloneNode(true)); // on remplace le bouton par une copie du bouton (pour retirer les event listeners)
    btnCancel.replaceWith(btnCancel.cloneNode(true)); // on remplace le bouton par une copie du bouton (pour retirer les event listeners)
    btnConfirm = document.getElementById("confirmBtn"); // on récupère le nouveau bouton de confirmation
    btnCancel = document.getElementById("cancelBtn"); // on récupère le nouveau bouton d'annulation

    if (type === "confirm") {
        btnCancel.style.display = "inline-block";
        btnConfirm.addEventListener("click", () => {
            modal.close();
            confirmCallback();
        });
        btnCancel.addEventListener("click", () => {
            modal.close();
            if (cancelCallback) cancelCallback();
        });
    } else if (type === "alert") {
        btnConfirm.addEventListener("click", () => {
            modal.close();
        });
        btnCancel.style.display = "none";
    } else if (type === "prompt") {
        const select = document.createElement("select");
        select.id = "selectAdherent";
        M.tabAdherents.forEach(adherent => {
            const option = document.createElement("option");
            option.value = adherent.numAdherent;
            option.innerHTML = adherent.nom + " " + adherent.prenom;
            select.appendChild(option);
        });
        modal.querySelector("label").appendChild(select);

        btnConfirm.addEventListener("click", () => {
            modal.close();
            confirmCallback(document.getElementById("selectAdherent").value);
        });
        btnCancel.addEventListener("click", () => {
            modal.close();
            if (cancelCallback) cancelCallback();
        });
    } else if (type === "afficherListe") {
        const ul = document.createElement("ul");
        ul.id = "ulListe";
        listes.forEach(livre => {
            const li = document.createElement("li");
            li.innerHTML = livre.titre + " - (" + livre.auteur+")";
            ul.appendChild(li);
        });
        modal.querySelector("label").appendChild(ul);
    } else {
        console.error("Type de modal non reconnu");
    }
}



