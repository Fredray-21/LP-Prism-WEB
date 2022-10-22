<?php
require_once("./modele/auteur.php");
if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["nationalite"]) && !empty($_POST["anneeNaissance"]) && !empty($_POST["numAuteur"])) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $nationalite = $_POST["nationalite"];
    $anneeNaissance = $_POST["anneeNaissance"];
    $numAuteur = $_POST["numAuteur"];

    Auteur::updateAuteur($numAuteur, $nom, $prenom, $nationalite, $anneeNaissance);
    // refresh the page
}
header("Location: lesAuteurs.php");
