<?php
require_once("modele/Auteur.php");

class ControleurAuteur extends ControleurObjet
{
    protected static $objet = "Auteur";
    protected static $cle = "numAuteur";
    protected static $tableauChamps = array(
        "nomAuteur" => ["text", "Nom"],
        "prenomAuteur" => ["text", "Prénom"],
        "anneeNaissance" => ["number", "Année de naissance"],
    );


    public static function afficherFormulaireCreationAuteur()
    {
        $titre = "Création d'un auteur";

        include("vue/debut.php");
        include(Session::urlMenu());
        include("vue/formulaireModificationObjet.php");
        include("vue/fin.html");
    }


    public static function ajouterNationaliteDeAuteur()
    {
        $titre = "Ajout d'une Nationalite";
        $tableau[] = $_GET["numAuteur"];
        $tableau[] = $_GET["numNationalite"];

        $result = Auteur::addNationaliteForAuteur($tableau[0], $tableau[1]);

        if ($result) {
            header("Location: index.php?controleur=controleurAuteur&action=definirNationalites&numAuteur=" . $tableau[0]);
        } else {
            self::afficherFormulaireCreationObjet();
        }
    }

    public static function supprimerNationaliteDeAuteur()
    {
        $titre = "Suppression d'une Nationalite";
        $tableau[] = $_GET["numAuteur"];
        $tableau[] = $_GET["numNationalite"];

        $result = Auteur::deleteNationaliteForAuteur($tableau[0], $tableau[1]);

        if ($result) {
            header("Location: index.php?controleur=controleurAuteur&action=definirNationalites&numAuteur=" . $tableau[0]);
        } else {
            header("Location: index.php?controleur=ControleurNationalite&action=afficherFormulaireModificationObjet&numNationalite=" . $tableau[0]);
        }
    }

    public static function definirNationalites()
    {
        $titre = "Définition des Nationalite de l'auteur";
        $tableau[] = $_GET["numAuteur"];

        $tabNationalite = Auteur::getNationaliteByNumAuteur($tableau[0]);
        $tabNonNationalite = Auteur::getNonNationaliteByNumAuteur($tableau[0]);

        foreach ($tabNationalite as $nationalite) {
            $tableauAffichage[] = "<div class='ligne'><div><b>N°" . $nationalite->get('numNationalite') . "</b> " . $nationalite->get("pays") . " " . $nationalite->get("abrege") . "</div>" . "<a class='bouton btn-red' href='index.php?controleur=ControleurAuteur&action=supprimerNationaliteDeAuteur&numAuteur=" . $tableau[0] . "&numNationalite=" . $nationalite->get("numNationalite") . "'><i class='bi bi-trash'></i></a>" . "</div>";
        }
        $tableauAffichage[] = "<br />";

        foreach ($tabNonNationalite as $nationalite) {
            $tableauAffichage[] = "<div class='ligne'><div><b>N°" . $nationalite->get('numNationalite') . "</b> " . $nationalite->get("pays") . " " . $nationalite->get("abrege") . "</div>" . "<a class='bouton btn-green' href='index.php?controleur=ControleurAuteur&action=ajouterNationaliteDeAuteur&numAuteur=" . $tableau[0] . "&numNationalite=" . $nationalite->get("numNationalite") . "'><i class='bi bi-plus'></i></a>" . "</div>";
        }

        include("vue/debut.php");
        include(Session::urlMenu());
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }
}
