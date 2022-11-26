<?php
require_once("modele/Livre.php");

class ControleurLivre extends ControleurObjet
{
    protected static $objet = "Livre";
    protected static $cle = "numLivre";
    protected static $tableauChamps = array(
        "titre" => ["text", "Titre"],
        "anneeParution" => ["number", "Annee de parution"],
        "numGenre" => ["select", "Genre"],

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

    public static function modifierLivre()
    {
        $titre = "Modification d'un Livre";
        $tableau[] = $_GET["identifiant"];
        $tableau[] = $_GET["titre"];
        $tableau[] = $_GET["anneeParution"];
        $tableau[] = $_GET["numGenre"];

        $result = Livre::updateLivre($tableau[0], $tableau[1], $tableau[2], $tableau[3]);

        if ($result) {
            self::lireObjets();
        } else {
            self::afficherFormulaireModificationObjet();
        }
    }


    public static function ajouterAuteurDuLivre()
    {
        $titre = "Ajout d'un auteur au livre";
        $tableau[] = $_GET["numLivre"];
        $tableau[] = $_GET["numAuteur"];

        $result = Livre::addAuteurForLivre($tableau[0], $tableau[1]);

        if ($result) {
            header("Location: index.php?controleur=controleurLivre&action=definirAuteurs&numLivre=" . $tableau[0]);
        } else {
            header("Location: index.php?controleur=ControleurLivre&action=afficherFormulaireAjoutAuteurDuLivre&numLivre=" . $tableau[0]);
        }
    }

    public static function supprimerAuteurDuLivre()
    {
        $titre = "Suppression d'un auteur du livre";
        $tableau[] = $_GET["numLivre"];
        $tableau[] = $_GET["numAuteur"];

        $result = Livre::deleteAuteurForLivre($tableau[0], $tableau[1]);

        if ($result) {
            header("Location: index.php?controleur=controleurLivre&action=definirAuteurs&numLivre=" . $tableau[0]);
        } else {
            header("Location: index.php?controleur=ControleurLivre&action=afficherFormulaireModificationObjet&numLivre=" . $tableau[0]);
        }
    }

    public static function definirAuteurs()
    {
        $titre = "Définition des auteurs du livre";
        $tableau[] = $_GET["numLivre"];

        $tabAuteurs = Livre::getAuteursByNumLivre($tableau[0]);
        $tabNonAuteurs = Livre::getNonAuteursByNumLivre($tableau[0]);

        foreach ($tabAuteurs as $auteur) {
            $tableauAffichage[] = "<div class='ligne'><div><b>N°" . $auteur->get("numAuteur") . "</b> " . $auteur->get("nomAuteur") . " " . $auteur->get("prenomAuteur") . "</div>" . "<a class='bouton btn-red' href='index.php?controleur=ControleurLivre&action=supprimerAuteurDuLivre&numLivre=" . $tableau[0] . "&numAuteur=" . $auteur->get("numAuteur") . "'><i class='bi bi-trash'></i></a>" . "</div>";
        }
        $tableauAffichage[] = "<br />";

        foreach ($tabNonAuteurs as $auteur) {
            $tableauAffichage[] = "<div class='ligne'><div><b>N°" . $auteur->get("numAuteur") . "</b> " . $auteur->get("nomAuteur") . " " . $auteur->get("prenomAuteur") . "</div>" . "<a class='bouton btn-green' href='index.php?controleur=ControleurLivre&action=ajouterAuteurDuLivre&numLivre=" . $tableau[0] . "&numAuteur=" . $auteur->get("numAuteur") . "'><i class='bi bi-plus'></i></a>" . "</div>";
        }

        include("vue/debut.php");
        include(Session::urlMenu());
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }
}
