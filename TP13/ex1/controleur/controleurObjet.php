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
                $lienGestionLivre = "";

                if (static::$objet == "Livre" && $objet->estDisponible()) {
                    $lienGestionLivre = "<a class='bouton btn-green btn-gestionLivre' href=\"index.php?controleur=controleurLivre&action=afficherFormulaireEmpruntLivremprunterLivre&" . static::$cle . "=$numObjet\">Emprunt <i class='bi bi-bag-plus'></i></a>";
                } else {
                    $lienGestionLivre = "<a class='bouton btn-green btn-gestionLivre' href=\"index.php?controleur=controleurLivre&action=retournerLivre&" . static::$cle . "=$numObjet\">Retour <i class='bi bi-send'></i></a>";
                }

                $lienAffichage = "$lienDefinir $lienDetails $lienModification $lienSuppression";

                if (static::$objet == "Livre") {
                    $lienDefinir = "<a class='bouton btn-orange' href=\"index.php?controleur=controleur" . static::$objet . "&action=definirAuteurs&" . static::$cle . "=$numObjet\"><i class='bi bi-pencil-square'></i></a>";
                }
                if (static::$objet == "Auteur") {
                    $lienDefinir = "<a class='bouton btn-orange' href=\"index.php?controleur=controleur" . static::$objet . "&action=definirNationalites&" . static::$cle . "=$numObjet\"><i class='bi bi-pencil-square'></i></a>";
                }

                if (static::$objet != "DateEmprunt") {
                    $cle = static::$cle;
                    $objet = static::$objet;

                    if (Session::adminConnected()) {
                        $lienModification = "<a class='bouton btn-blue' href=\"index.php?controleur=controleur" . static::$objet . "&action=afficherFormulaireModificationObjet&" . static::$cle . "=$numObjet\"><i class='bi bi-pen'></i></a>";
                        $lienSuppression = "<button class='bouton btn-red' onclick=\"openModal('$objet', '$numObjet', '$cle')\"><i class='bi bi-trash'></i></button>";

                        if (static::$objet == "Livre") {
                            $lienAffichage = "$lienDefinir $lienDetails $lienModification $lienSuppression $lienGestionLivre";
                        } else {
                            $lienAffichage = "$lienDefinir $lienDetails $lienModification $lienSuppression";
                        }

                    } else {
                        if (Session::userConnected() && $objet == "Adherent" && $numObjet == $_SESSION['login']) {
                            $lienModification = "<a class='bouton btn-blue' href=\"index.php?controleur=controleur" . static::$objet . "&action=afficherFormulaireModificationObjet&" . static::$cle . "=$numObjet\"><i class='bi bi-pen'></i></a>";
                            $lienAffichage = "$lienModification $lienDetails";
                        }
                    }
                }

                $tableauAffichage[] = "<div class='ligne'><div><b>N°$numObjet</b> $ObjetUn $ObjetDeux</div><div>$lienAffichage</div></div>";
            }
        }

        include("vue/debut.php");
        include(Session::urlMenu());
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }

    public static function lireObjet()
    {
        if (Session::userConnected()) {
            $titre = "détails " . strtolower(static::$objet);
            $numObjet = $_GET[static::$cle];
            $objet = static::$objet::getObjetById($numObjet);
            $objetData = $objet->afficher();
            $tableauAffichage = array();
            $tableauAffichage[] = "<div class='ligne'><div><b>" . static::$objet . "</b> $objetData </div></div>";

            include("vue/debut.php");
            include(Session::urlMenu());
            include("vue/lesObjets.php");
            include("vue/fin.html");
        } else {
            header("Location: index.php");
        }
    }

    public
    static function afficherFormulaireCreationObjet()
    {
        if (Session::adminConnected()) {
            $titre = "Création d'un " . strtolower(static::$objet);

            include("vue/debut.php");
            include(Session::urlMenu());
            include("vue/formulaireCreationObjet.php");
            include("vue/fin.html");
        } else {
            self::lireObjets();
        }

    }

    public
    static function afficherFormulaireModificationObjet()
    {
        if (Session::adminConnected() || (Session::userConnected() && static::$objet == "Adherent" && $_GET[static::$cle] == $_SESSION['login'])) {
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
        } else {
            self::lireObjets();
        }
    }

    public
    static function supprimerObjet()
    {
        if (Session::adminConnected()) {
            $titre = "Suppression d'un " . strtolower(static::$objet);
            $numObjet = $_GET[static::$cle];
            $result = static::$objet::deleteObjetById($numObjet);

            if ($result) {
                self::lireObjets();
            } else {
                self::lireObjet();
            }
        } else {
            self::lireObjets();
        }
    }

    public
    static function creerObjet()
    {
        if (Session::adminConnected()) {
            $table = static::$objet;

            $tableauDonnees = $_GET;
            unset($tableauDonnees['controleur']);
            unset($tableauDonnees['action']);

            $result = $table::addObjet($tableauDonnees);

            if ($result) {
                self::lireObjets();
            } else {
                self::afficherFormulaireCreationObjet();
            }
        } else {
            self::lireObjets();
        }
    }

    public
    static function modifierObjet()
    {
        if (Session::adminConnected() || (Session::userConnected() && static::$objet == "Adherent" && $_GET[static::$cle] == $_SESSION['login'])) {
            $table = static::$objet;
            $cle = static::$cle;

            $tableauDonnees = $_GET;
            unset($tableauDonnees['controleur']);
            unset($tableauDonnees['action']);
            unset($tableauDonnees['identifiant']);
            $tableauDonnees[$cle] = $_GET['identifiant'];

            $result = $table::updateObjet($tableauDonnees);

            if ($result) {
                self::lireObjets();
            } else {
                self::afficherFormulaireModificationObjet();
            }
        } else {
            self::lireObjets();
        }
    }

}
