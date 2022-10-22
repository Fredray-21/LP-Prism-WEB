<?php
require_once("./modele/auteur.php");
if (isset($_GET['numAuteur'])) {
    $numAuteur = $_GET['numAuteur'];
    echo "numAuteur: " . $numAuteur . "<br>";
    Auteur::deleteAuteur($numAuteur);
}
header("Location: routeur.php");
