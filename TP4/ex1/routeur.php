<?php
//connexion à la DB
require_once("config/connexion.php");
Connexion::connect();

//le controleur
require_once("controleur/controleurAuteur.php");
require_once("controleur/controleurAdherent.php");

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
    ControleurAdherent::$action();
    break;
  case "lireAdherent":
    ControleurAdherent::$action();
    break;
  default:
    ControleurAuteur::$action();
    break;
}
