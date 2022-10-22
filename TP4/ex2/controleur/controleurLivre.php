<?php
require_once("modele/Livre.php");

class ControleurLivre
{

    public static function lireLivres()
    {
        $titre = "Les Livres";
        $tableau = Livre::getAllLivre();
        $tableauAffichage = [];
        foreach ($tableau as $unLivre) {
            $numLivre = $unLivre->getNumLivre();
            $titreLivre = $unLivre->getTitre();
            $anneeParutionLivre = $unLivre->getAnneeParution();
            $numGenreLivre = $unLivre->getNumGenre();
            $lienDetails = "<a class='bouton' href='routeur.php?controleur=controleurLivre&action=lireLivre&numLivre=$numLivre'>Details</a>";
            $tableauAffichage[] = "<div class='ligne'><div>Livre $titreLivre $anneeParutionLivre $numGenreLivre </div><div> $lienDetails</div></div>";
        }
        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }

    public static function lireLivre()
    {
        $titre = "un Livre";
        $numLivre = $_GET["numLivre"];
        $object = Livre::getLivrebynum($numLivre);

        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }
}
