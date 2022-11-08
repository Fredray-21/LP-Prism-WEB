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
            self::lireObjets();
        } else {
            self::afficherFormulaireCreationObjet();
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
        include(Session::urlMenu());
        include("vue/formulaireModificationObjet.php");
        include("vue/fin.html");
    }

    public static function modifierCategorie()
    {
        $titre = "Modification d'une Categorie";
        $tableau[] = $_GET["identifiant"];
        $tableau[] = $_GET["libelle"];
        $tableau[] = $_GET["nbLivresAutorises"];

        $result = Categorie::updateCategorie($tableau[0], $tableau[1], $tableau[2]);

        if ($result) {
            self::lireObjets();
        } else {
            header("Location: index.php?controleur=ControleurCategorie&action=afficherFormulaireModificationObjet&numCategorie=" . $tableau[0]);
        }
    }
}
