<?php
//connexion à la DB
require_once("config/connexion.php");
Connexion::connect();
require_once('modele/Objet.php');
require_once('controleur/controleurObjet.php');
require_once('modele/Session.php');

Objet::requireAllControllers();

$Controleur = "ControleurAuteur";
$action = "lireObjets";
if (!Session::userConnected() && !Session::userConnecting()) {
  $action = "afficherFormulaireConnexion";
  $Controleur = "controleurAdherent";
} else {
  if (!empty($_GET["action"]) && !empty($_GET["controleur"]) && in_array($_GET["action"], get_class_methods($_GET["controleur"]))) {
    $action = $_GET["action"];
    $Controleur = $_GET["controleur"];
  }
}

$Controleur::$action();
