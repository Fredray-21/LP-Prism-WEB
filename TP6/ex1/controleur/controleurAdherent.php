<?php
require_once("./modele/Adherent.php");

class ControleurAdherent extends ControleurObjet
{
    protected static $objet = "Adherent";
    protected static $cle = "login";
    protected static $tableauChamps = array(
        "login" => ["text", "Login"],
        "mdp" => ["text", "Mots de passe"],
        "nomAdherent" => ["text", "Nom"],
        "prenomAdherent" => ["text", "Prénom"],
        "email" => ["text", "Email"],
        "numCategorie" => ["number", "Numéro de catégorie"],
    );

    public static function afficherFormulaireCreationAdherent()
    {
        $titre = "Création d'un Adherent";

        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/formulaireCreationAdherent.html");
        include("vue/fin.html");
    }

    public static function creerAdherent()
    {
        $titre = "Création d'un Adherent";
        $tableau[] = $_GET["login"];
        $tableau[] = $_GET["mdp"];
        $tableau[] = $_GET["nomAdherent"];
        $tableau[] = $_GET["prenomAdherent"];
        $tableau[] = $_GET["email"];
        $tableau[] = $_GET["numCategorie"];


        $result = Client::addAdherent($tableau[0], $tableau[1], $tableau[2], $tableau[3], $tableau[4], $tableau[5]);

        if ($result) {
            header("Location: routeur.php?controleur=ControleurAdherent&action=lireObjets");
        } else {
            header("Location: routeur.php?controleur=ControleurAdherent&action=afficherFormulaireCreationObjet");
        }
    }
}
