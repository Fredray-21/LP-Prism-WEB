<?php
require_once("modele/Nationalite.php");

class ControleurNationalite extends ControleurObjet
{
    protected static $objet = "Nationalite";
    protected static $cle = "numNationalite";
    protected static $tableauChamps = array(
        "pays" => ["text", "Pays"],
        "abrege" => ["text", "Abrege"]
    );

    public static function creerNationalite(){
        $titre = "Création d'une Nationalite";
        $tableau[] = $_GET["pays"];
        $tableau[] = $_GET["abrege"];

        $result = Nationalite::addNationalite($tableau[0], $tableau[1]);

        if ($result) {
            header("Location: routeur.php?controleur=ControleurNationalite&action=lireObjets");
        } else {
            header("Location: routeur.php?controleur=ControleurNationalite&action=afficherFormulaireCreationObjet");
        }
    }
}
