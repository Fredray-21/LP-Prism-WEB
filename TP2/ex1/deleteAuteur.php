<?php
require_once("./auteur.php");
if (isset($_GET['numAuteur'])) {
    $numAuteur = $_GET['numAuteur'];
    echo "numAuteur: " . $numAuteur . "<br>";
    Auteur::deleteAuteur($numAuteur);
}
header("Location: lesAuteurs.php");
