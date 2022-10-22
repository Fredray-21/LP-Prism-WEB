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

    public static function afficherFormulaireModificationObjet()
    {
        // On récupère l'objet à modifier
        $table = static::$objet;
        $cle = static::$cle;
        $objet = $table::getObjetById($_GET[$cle]);

        // On récupère les champs de l'objet
        $tableauChamps = static::$tableauChamps;
        $tableauChamps["identifiant"] = $_GET[$cle];

        // On récupère le titre de la page
        $titre = "Modification d'un " . static::$objet;

        // On affiche la page
        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/formulaireModificationObjet.php");
        include("vue/fin.html");
    }


    public static function modifierGenre()
    {
        $titre = "Modification d'un Genre";
        $tableau[] = $_GET["identifiant"];
        $tableau[] = $_GET["intitule"];

        $result = Genre::updateGenre($tableau[0], $tableau[1]);

        if ($result) {
            header("Location: routeur.php?controleur=ControleurGenre&action=lireObjets");
        } else {
            header("Location: routeur.php?controleur=ControleurGenre&action=afficherFormulaireModificationObjet&numGenre=" . $tableau[0]);
        }
    }
}
