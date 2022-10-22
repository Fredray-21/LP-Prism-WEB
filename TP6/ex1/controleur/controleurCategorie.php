<?php
require_once("modele/Categorie.php");

class ControleurCategorie extends ControleurObjet
{
    protected static $objet = "Categorie";
    protected static $cle = "numCategorie";
    protected static $tableauChamps = array(
        "libelle" => ["text", "Libelle"],
        "nbLivresAutorises" => ["number", "Nombre de livres autorises"]
    );


    public static function creerCategorie()
    {
        $titre = "Création d'une Categorie";
        $tableau[] = $_GET["libelle"];
        $tableau[] = $_GET["nbLivresAutorises"];

        $result = Categorie::addCategorie($tableau[0], $tableau[1]);

        if ($result) {
            header("Location: routeur.php?controleur=ControleurCategorie&action=lireObjets");
        } else {
            header("Location: routeur.php?controleur=ControleurCategorie&action=afficherFormulaireCreationObjet");
        }
    }
}
