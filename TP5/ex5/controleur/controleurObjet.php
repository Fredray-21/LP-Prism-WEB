<?php

class ControleurObjet
{

    public static function lireObjets()
    {
        $titre = "les " . strtolower(static::$objet) . "s";
        $tableau = static::$objet::getAllObjects();
        $tableauAffichage = array();
        foreach ($tableau as $objet) {
            $numObjet = $objet->get(static::$cle);
            $lienDetails = "<a class='bouton' href=\"routeur.php?controleur=controleur" . static::$objet . "&action=lireObjet&" . static::$cle . "=$numObjet\"> détails </a>";
            $tableauAffichage[] = "<div class='ligne'><div><b>" . static::$objet . "</b> $numObjet</div><div> $lienDetails</div></div>";
        }

        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }

    public static function lireObjet()
    {
        $titre = "détails " . strtolower(static::$objet);
        $numObjet = $_GET[static::$cle];
        $objet = static::$objet::getObjetById($numObjet);
        $tableauAffichage = array();
        $tableauAffichage[] = "<div class='ligne'><div><b>" . static::$objet . "</b> $numObjet</div></div>";

        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }
}
