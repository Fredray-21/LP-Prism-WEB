<?php
require_once("./modele/Adherent.php");

class ControleurAdherent
{
    public static function lireAdherents()
    {
        $titre = "Les Adherent";
        $tableau = Client::getAllAdherent();
        $tableauAffichage = [];
        foreach ($tableau as $unAdherent) {
            $loginAdherent = $unAdherent->getLogin();
            $mdpAdherent = $unAdherent->getMdp();
            $nomAdherent = $unAdherent->getNomAdherent();
            $prenomAdherent = $unAdherent->getPrenomAdherent();
            $emailAdherent = $unAdherent->getEmail();
            $dateAdhesionAdherent = $unAdherent->getDateAdhesion();
            $numCategorieAdherent = $unAdherent->getNumCategorie();
            $lienDetails = "<a class='bouton' href='routeur.php?controleur=controleurAdherent&action=lireAdherent&loginAdherent=$loginAdherent'>Details</a>";
            $tableauAffichage[] = "<div class='ligne'><div>Adherent $prenomAdherent $nomAdherent $emailAdherent $dateAdhesionAdherent </div><div> $lienDetails</div></div>";
        }
        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/lesAdherents.php");
        include("vue/fin.html");
    }

    public static function lireAdherent()
    {
        $titre = "un Adherent";
        $login = $_GET["loginAdherent"];
        $adherent = Client::getAdherentByLogin($login);
        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/unAdherent.php");
        include("vue/fin.html");
    }
}
