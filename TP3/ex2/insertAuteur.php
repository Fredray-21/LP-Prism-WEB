<?php
require_once("./modele/auteur.php");
// if the form is submitted
if (!empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["nationalite"]) && !empty($_POST["anneeNaissance"])) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $nationalite = $_POST["nationalite"];
    $anneeNaissance = $_POST["anneeNaissance"];
    Auteur::insertAuteur($nom, $prenom, $nationalite, $anneeNaissance);
    // refresh the page
}
header("Location: routeur.php");
