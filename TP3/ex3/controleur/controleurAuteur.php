<?php
require_once("./modele/auteur.php");
// get aull Auteurs in database
$auteurs =  Auteur::getAllAuteurs();

// si btn "update" est cliqué  -> sinon Ajouté
if (!empty($_GET["numAuteur"])) {
    $numAuteur = $_GET["numAuteur"];
    $auteur = Auteur::getAuteur($numAuteur);
    $textBTN = "Valider les modifications";
} else {
    $numAuteur = "";
    $auteur = new Auteur();
    $textBTN = "Ajouter l'Auteur";
}


// get action actual 
if (!empty($_GET["action"])) {
    $action = $_GET["action"];
} else {
    $action = "";
}

$name = $auteur->getNom();
$prenom = $auteur->getPrenom();
$nationalite = $auteur->getNationalite();
$anneeNaissance = $auteur->getAnneeNaissance();

// insert AUTHOR
if ($action == "insert" && !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["nationalite"]) && !empty($_POST["anneeNaissance"])) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $nationalite = $_POST["nationalite"];
    $anneeNaissance = $_POST["anneeNaissance"];
    Auteur::insertAuteur($nom, $prenom, $nationalite, $anneeNaissance);
    // refresh the page
    header("Location: routeur.php");
}


//UPDATE AUTHOR
if ($action == "update" && !empty($_POST["nom"]) && !empty($_POST["prenom"]) && !empty($_POST["nationalite"]) && !empty($_POST["anneeNaissance"]) && !empty($_POST["numAuteur"])) {
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $nationalite = $_POST["nationalite"];
    $anneeNaissance = $_POST["anneeNaissance"];
    $numAuteur = $_POST["numAuteur"];
    Auteur::updateAuteur($numAuteur, $nom, $prenom, $nationalite, $anneeNaissance);
    // refresh the page
    header("Location: routeur.php");
}

//DELETE AUTHOR
if ($action = "delete" && isset($_GET['numAuteur']) && isset($_GET['action']) && $_GET['action'] == "delete") {
    $numAuteur = $_GET['numAuteur'];
    echo "numAuteur: " . $numAuteur . "<br>";
    Auteur::deleteAuteur($numAuteur);
    // refresh the page
    header("Location: routeur.php");
}


require_once("./vue/lesAuteurs.php");
