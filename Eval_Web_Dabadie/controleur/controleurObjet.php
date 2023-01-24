<?php

class ControleurObjet
{

    public static function lireObjets()
    {
        $titre = "les " . strtolower(static::$objet) . "s";
        $tableau = static::$objet::getAllObjects();
        $tableauAffichage = array();
        $ObjetUn = "";
        $ObjetDeux = "";

        foreach ($tableau as $objet) {
            $numObjet = $objet->get(static::$cle);

            switch (static::$objet) {
                case "Article":
                    $ObjetUn = $objet->get("libelle");
                    $ObjetDeux = $objet->get("prix") . "€";
                    break;
                case "Client":
                    $ObjetUn = $objet->get("nom" . static::$objet);
                    $ObjetDeux = $objet->get("prenom" . static::$objet);
                    break;
                default:
                    $ObjetUn = "";
                    $ObjetDeux = "";
                    break;
            }


            $lienDetails = "<a class='bouton btn-rose' href=\"index.php?controleur=controleur" . static::$objet . "&action=lireObjet&" . static::$cle . "=$numObjet\"><i class='bi bi-eye'></i></a>";
            $lienModification = "";
            $lienSuppression = "";
            $lienAddPanier = "";

            if (Session::adminConnected()) {
                $lienModification = "<a class='bouton btn-blue' href=\"index.php?controleur=controleurArticle&action=afficherFormulaireModificationObjet&code_article=$numObjet\"><i class='bi bi-pen'></i></a>";
                $lienSuppression = "<a class='bouton btn-red' href=\"index.php?controleur=controleurArticle&action=supprimerObjet&code_article=$numObjet\"><i class='bi bi-trash'></i></a>";
            }

            if (static::$objet == "Article") {
                $lienAddPanier = "<a class='bouton btn-green' href=\"index.php?controleur=controleur" . static::$objet . "&action=addInPanier&" . static::$cle . "=$numObjet\"><i class='bi bi-cart-plus'></i></a>";
            }
            $lienAffichage = "$lienAddPanier $lienDetails $lienModification $lienSuppression";

            $tableauAffichage[] = "<div class='ligne'><div><b>N°$numObjet</b> $ObjetUn $ObjetDeux</div><div>$lienAffichage</div></div>";
        }

        include("vue/debut.php");
        include("vue/menu.php");
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }

    public static function lireObjet()
    {
        $titre = "détails " . strtolower(static::$objet);
        $numObjet = $_GET[static::$cle];
        $objet = static::$objet::getObjetById($numObjet);
        $objetData = $objet->afficher();
        $tableauAffichage = array();
        $tableauAffichage[] = "<div class='ligne'><div><b>" . static::$objet . "</b> $objetData</div></div>";

        include("vue/debut.php");
        include("vue/menu.php");
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }

    public static function afficherFormulaireCreationObjet()
    {
        $titre = "Création d'un " . strtolower(static::$objet);

        include("vue/debut.php");
        include("vue/menu.php");
        include("vue/formulaireCreationObjet.php");
        include("vue/fin.html");
    }

    public static function supprimerObjet()
    {
        $titre = "Suppression d'un " . strtolower(static::$objet);
        $numObjet = $_GET[static::$cle];
        $result = static::$objet::deleteObjetById($numObjet);

        if ($result) {
            header("Location: index.php?controleur=controleur" . static::$objet . "&action=lireObjets");
        } else {
            header("Location: index.php?controleur=controleur" . static::$objet . "&action=lireObjet&" . static::$cle . "=$numObjet");
        }
    }

    public static function afficherFormulaireModificationObjet()
    {
        if (Session::adminConnected() || (Session::userConnected() && static::$objet == "Adherent" && $_GET[static::$cle] == $_SESSION['user'])) {
//         On récupère l'objet à modifier
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
            include("vue/menu.php");
            include("vue/formulaireModificationObjet.php");
            include("vue/fin.html");
        } else {
            self::lireObjets();
        }
    }


}
