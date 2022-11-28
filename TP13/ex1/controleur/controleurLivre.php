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

    public static function ajouterAuteurDuLivre()
    {
        if (Session::adminConnected()) {
            $titre = "Ajout d'un auteur au livre";
            $tableau[] = $_GET["numLivre"];
            $tableau[] = $_GET["numAuteur"];

            $result = Livre::addAuteurForLivre($tableau[0], $tableau[1]);

            if ($result) {
                header("Location: index.php?controleur=controleurLivre&action=definirAuteurs&numLivre=" . $tableau[0]);
            } else {
                header("Location: index.php?controleur=ControleurLivre&action=afficherFormulaireAjoutAuteurDuLivre&numLivre=" . $tableau[0]);
            }
        } else {
            header("Location: index.php?controleur=controleurLivre&action=lireObjets");
        }
    }

    public static function supprimerAuteurDuLivre()
    {
        if (Session::adminConnected()) {
            $titre = "Suppression d'un auteur du livre";
            $tableau[] = $_GET["numLivre"];
            $tableau[] = $_GET["numAuteur"];

            $result = Livre::deleteAuteurForLivre($tableau[0], $tableau[1]);

            if ($result) {
                header("Location: index.php?controleur=controleurLivre&action=definirAuteurs&numLivre=" . $tableau[0]);
            } else {
                header("Location: index.php?controleur=ControleurLivre&action=afficherFormulaireModificationObjet&numLivre=" . $tableau[0]);
            }
        } else {
            header("Location: index.php?controleur=controleurLivre&action=lireObjets");
        }
    }

    public static function definirAuteurs()
    {
        if (Session::adminConnected()) {
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
        } else {
            header("Location: index.php");
        }
    }
}

