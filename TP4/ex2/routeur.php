<?php
//connexion à la DB
require_once("config/connexion.php");
Connexion::connect();

require_once('modele/Objet.php');
//le controleur
require_once("controleur/controleurAuteur.php");
require_once("controleur/controleurAdherent.php");
require_once("controleur/controleurLivre.php");

//le modèle
$action = "lireAuteurs";

if (!empty($_GET["action"]) && !empty($_GET["controleur"]) && in_array($_GET["action"], get_class_methods($_GET["controleur"]))) {
    $action = $_GET["action"];
}

switch ($action) {
    case "lireAuteurs":
        ControleurAuteur::$action();
        break;
    case "lireAuteur":
        ControleurAuteur::$action();
        break;
    case "lireAdherents":
        ControleurClient::$action();
        break;
    case "lireAdherent":
        ControleurClient::$action();
        break;
    case "lireLivres":
        ControleurLivre::$action();
        break;
    case "lireLivre":
        ControleurLivre::$action();
        break;
    default:
        ControleurAuteur::$action();
        break;
}
