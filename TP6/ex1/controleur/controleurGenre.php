<?php
require_once("modele/Genre.php");

class ControleurGenre extends ControleurObjet
{
    protected static $objet = "Genre";
    protected static $cle = "numGenre";
    protected static $tableauChamps = array(
        "intitule" => ["text", "Intitule"]
    );

    public static function creerGenre()
    {
        $titre = "Création d'une Genre";
        $tableau[] = $_GET["intitule"];

        $result = Genre::addGenre($tableau[0]);

        if ($result) {
            header("Location: routeur.php?controleur=ControleurGenre&action=lireObjets");
        } else {
            header("Location: routeur.php?controleur=ControleurGenre&action=afficherFormulaireCreationObjet");
        }
    }
}
