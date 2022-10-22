<?php
//connexion à la DB
require_once("config/connexion.php");
Connexion::connect();
require_once('modele/Objet.php');
require_once('controleur/controleurObjet.php');

Objet::requireAllControllers();

if (!empty($_GET["action"]) && !empty($_GET["controleur"]) && in_array($_GET["action"],get_class_methods($_GET["controleur"]))) {
  $action = $_GET["action"];
  $Controleur = $_GET["controleur"];
  $Controleur::$action();
} else {
  $Controleur = "ControleurAuteur";
  $action = "lireObjets";
  $Controleur::$action();
}
