const modal = document.getElementById("id01");

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
        closeModal();
    }
}

function openModal(objet, id, cle) {
    modal.querySelector(".modal-header h1").innerHTML = "Supprimer " + objet;
    modal.querySelector(".modal-content .container p").innerHTML = "Voulez-vous vraiment supprimer <b>" + objet + " " + id + " ?</b>";

    document.documentElement.style.overflow = 'hidden';
    modal.style.display = "block";
    const btnDelete = document.querySelector(".deletebtn");
    btnDelete.addEventListener("click", function () {
        modal.style.display = "none";
        window.location.href = `index.php?controleur=controleur${objet}&action=supprimerObjet&${cle}=${id}`;
    });
}

function closeModal() {
    modal.style.display = "none";
    document.documentElement.style.overflow = 'auto';
};const listeObjets = document.querySelectorAll("#results .ligne");

// add animation fade in in différente vitesse
for (let i = 0; i < listeObjets.length; i++) {
    listeObjets[i].style.animation = "fadein 1s " + (i / 10) + "s forwards";
}

const switch_home = document.querySelector("#switch-home");
const form_connexion = document.querySelector("#form-connexion");
const form_inscription = document.querySelector("#form-inscription");

switch_home.addEventListener("click", function () {
    if (switch_home.checked) {
        form_connexion.style.display = "none";
        form_inscription.style.display = "block";
    } else {
        form_connexion.style.display = "block";
        form_inscription.style.display = "none";
    }
});
