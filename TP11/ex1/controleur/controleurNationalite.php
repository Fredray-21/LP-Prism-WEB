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

}
