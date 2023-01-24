<?php
//connexion à la DB
require_once("config/connexion.php");
Connexion::connect();
require_once('modele/Objet.php');
require_once('controleur/controleurObjet.php');
require_once('modele/Session.php');
require_once('controleur/controleurObjet.php');
require_once('controleur/controleurClient.php');
require_once('controleur/controleurArticle.php');

$Controleur = "ControleurArticle";
$action = "lireObjets";

if (!Session::userConnected() && !Session::userConnecting() && !Session::userCreating()) {
    $Controleur = "ControleurClient";
    $action = "afficherFormulaireConnexion";
} else {
    if (!empty($_GET["action"]) && !empty($_GET["controleur"])) {
        $action = $_GET["action"];
        $Controleur = $_GET["controleur"];
    }
}

$Controleur::$action();
