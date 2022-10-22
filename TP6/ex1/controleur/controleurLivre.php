<?php
require_once("modele/Livre.php");

class ControleurLivre extends ControleurObjet
{
    protected static $objet = "Livre";
    protected static $cle = "numLivre";
    protected static $tableauChamps = array(
        "titre" => ["text", "Titre"],
        "anneeParution" => ["number", "Annee de parution"],
        "numGenre" => ["number", "numGenre"]
    );


    public static function creerLivre(){
        $titre = "Création d'un Livre";
        $tableau[] = $_GET["titre"];
        $tableau[] = $_GET["anneeParution"];
        $tableau[] = $_GET["numGenre"];

        $result = Livre::addLivre($tableau[0], $tableau[1], $tableau[2]);

        if ($result) {
            header("Location: routeur.php?controleur=ControleurLivre&action=lireObjets");
        } else {
            header("Location: routeur.php?controleur=ControleurLivre&action=afficherFormulaireCreationObjet");
        }
    }
}
