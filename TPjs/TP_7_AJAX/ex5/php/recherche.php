<?php
require_once("connexion.php");
Connexion::connect();
require_once("modele.php");

// récupération de la lettre et du type de recherche, passés en get
$lettre = $_GET['lettre'];
$type = $_GET['type'];

// récupération du résultat de la requête SQL
$tab_verbes = Modele::select($lettre,$type);

// affichage pour le responseText de l'objet XmlHttpRequest
echo json_encode($tab_verbes);
