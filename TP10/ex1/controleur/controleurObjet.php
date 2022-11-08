<?php

require_once 'modele/Modal.php';

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
            $affichable = $objet->affichable();

            if ($affichable) {
                switch (static::$objet) {
                    case "Adherent":
                        $ObjetUn = $objet->get("nom" . static::$objet);
                        $ObjetDeux = $objet->get("prenom" . static::$objet);
                        break;
                    case "Auteur":
                        $ObjetUn = $objet->get("nom" . static::$objet);
                        $ObjetDeux = $objet->get("prenom" . static::$objet);
                        break;
                    case "Livre":
                        $ObjetUn = $objet->get("titre");
                        $ObjetDeux = $objet->get("anneeParution");
                        break;
                    case "Genre":
                        $ObjetUn = $objet->get("intitule");
                        break;
                    case "Nationalite":
                        $ObjetUn = $objet->get("pays");
                        $ObjetDeux = $objet->get("abrege");
                        break;
                    case "Categorie":
                        $ObjetUn = $objet->get("libelle");
                        break;
                    default:
                        $ObjetUn = "";
                        $ObjetDeux = "";
                        break;
                }

                $lienDetails = "<a class='bouton btn-rose' href=\"index.php?controleur=controleur" . static::$objet . "&action=lireObjet&" . static::$cle . "=$numObjet\"><i class='bi bi-eye'></i></a>";
                $lienModification = "";
                $lienSuppression = "";
                $lienDefinir = "";

                if (static::$objet != "DateEmprunt") {
                    $lienModification = "<a class='bouton btn-blue' href=\"index.php?controleur=controleur" . static::$objet . "&action=afficherFormulaireModificationObjet&" . static::$cle . "=$numObjet\"><i class='bi bi-pen'></i></a>";
                    $lienSuppression = "<a class='bouton btn-red' href=\"index.php?controleur=controleur" . static::$objet . "&action=supprimerObjet&" . static::$cle . "=$numObjet\"><i class='bi bi-trash'></i> </a>";
                }
                if (static::$objet == "Livre") {
                    $lienDefinir = "<a class='bouton btn-orange' href=\"index.php?controleur=controleur" . static::$objet . "&action=definirAuteurs&" . static::$cle . "=$numObjet\"><i class='bi bi-pencil-square'></i></a>";
                }
                if (static::$objet == "Auteur") {
                    $lienDefinir = "<a class='bouton btn-orange' href=\"index.php?controleur=controleur" . static::$objet . "&action=definirNationalites&" . static::$cle . "=$numObjet\"><i class='bi bi-pencil-square'></i></a>";
                }
                $tableauAffichage[] = "<div class='ligne'><div><b>N°$numObjet</b> $ObjetUn $ObjetDeux</div><div>$lienDefinir $lienDetails $lienModification $lienSuppression</div></div>";
            }
        }

        include("vue/debut.php");
        include(Session::urlMenu());
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
        include(Session::urlMenu());
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }

    public static function afficherFormulaireCreationObjet()
    {
        $titre = "Création d'un " . strtolower(static::$objet);

        include("vue/debut.php");
        include(Session::urlMenu());
        include("vue/formulaireCreationObjet.php");
        include("vue/fin.html");
    }

    public static function supprimerObjet()
    {
        $titre = "Suppression d'un " . strtolower(static::$objet);
        $numObjet = $_GET[static::$cle];
        $result = static::$objet::deleteObjetById($numObjet);

        if ($result) {
            self::lireObjets();
        } else {
            self::lireObjet();
        }
    }
}
