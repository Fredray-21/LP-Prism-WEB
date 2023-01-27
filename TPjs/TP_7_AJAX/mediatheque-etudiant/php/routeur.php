<?php
require_once("config/connexion.php");
Connexion::connect();
require_once("model/livre.php");
require_once("model/adherent.php");

$objet = $_GET["objet"];
$action = $_GET["action"];

include("actions/$objet/$action.php");
?>
