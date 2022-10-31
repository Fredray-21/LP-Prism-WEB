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
    include("vue/menu.html");
    include("vue/formulaireModificationObjet.php");
    include("vue/fin.html");
  }

  public static function creerAuteur()
  {
    $titre = "Création d'un auteur";
    $tableau[] = $_GET["nomAuteur"];
    $tableau[] = $_GET["prenomAuteur"];
    $tableau[] = $_GET["anneeNaissance"];

    $result = Auteur::addAuteur($tableau[0], $tableau[1], $tableau[2]);

    if ($result) {
      header("Location: routeur.php?controleur=ControleurAuteur&action=lireObjets");
    } else {
      header("Location: routeur.php?controleur=ControleurAuteur&action=afficherFormulaireCreationObjet");
    }
  }


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
    include("vue/menu.html");
    include("vue/formulaireModificationObjet.php");
    include("vue/fin.html");
  }

  public static function modifierAuteur()
  {
    $titre = "Modification d'un auteur";
    $tableau[] = $_GET["nomAuteur"];
    $tableau[] = $_GET["prenomAuteur"];
    $tableau[] = $_GET["anneeNaissance"];
    $tableau[] = $_GET["identifiant"];

    $result = Auteur::updateAuteur($tableau[0], $tableau[1], $tableau[2], $tableau[3]);

    if ($result) {
    self::lireObjets();
    } else {
      self::afficherFormulaireCreationAuteur();
    }
  }

  public static function ajouterNationaliteDeAuteur()
    {
        $titre = "Ajout d'une Nationalite";
        $tableau[] = $_GET["numAuteur"];
        $tableau[] = $_GET["numNationalite"];

        $result = Auteur::addNationaliteForAuteur($tableau[0], $tableau[1]);

        if ($result) {
          header("Location: routeur.php?controleur=controleurAuteur&action=definirNationalites&numAuteur=".$tableau[0]);
        } else {
            header("Location: routeur.php?controleur=ControleurNationalite&action=afficherFormulaireCreationObjet");
        }
    }

    public static function supprimerNationaliteDeAuteur()
    {
        $titre = "Suppression d'une Nationalite";
        $tableau[] = $_GET["numAuteur"];
        $tableau[] = $_GET["numNationalite"];

        $result = Auteur::deleteNationaliteForAuteur($tableau[0], $tableau[1]);

        if ($result) {
          header("Location: routeur.php?controleur=controleurAuteur&action=definirNationalites&numAuteur=".$tableau[0]);
        } else {
            header("Location: routeur.php?controleur=ControleurNationalite&action=afficherFormulaireModificationObjet&numNationalite=" . $tableau[0]);
        }
    }
    
    public static function definirNationalites()
    {
        $titre = "Définition des Nationalite de l'auteur";
        $tableau[] = $_GET["numAuteur"];

        $tabNationalite = Auteur::getNationaliteByNumAuteur($tableau[0]);
        $tabNonNationalite = Auteur::getNonNationaliteByNumAuteur($tableau[0]);

        foreach ($tabNationalite as $nationalite) {
            $tableauAffichage[] = "<div class='ligne'><div><b>N°".$nationalite->get('numNationalite')."</b> " . $nationalite->get("pays") . " " . $nationalite->get("abrege") . "</div>" . "<a class='bouton btn-red' href='routeur.php?controleur=ControleurAuteur&action=supprimerNationaliteDeAuteur&numAuteur=" . $tableau[0] . "&numNationalite=" . $nationalite->get("numNationalite") . "'><i class='bi bi-trash'></i></a>" . "</div>";
        }
        $tableauAffichage[] = "<br />";

        foreach ($tabNonNationalite as $nationalite) {
            $tableauAffichage[] = "<div class='ligne'><div><b>N°".$nationalite->get('numNationalite')."</b> " . $nationalite->get("pays") . " " . $nationalite->get("abrege") . "</div>" . "<a class='bouton btn-green' href='routeur.php?controleur=ControleurAuteur&action=ajouterNationaliteDeAuteur&numAuteur=" . $tableau[0] . "&numNationalite=" . $nationalite->get("numNationalite") . "'><i class='bi bi-plus'></i></a>" . "</div>";
        }

        include("vue/debut.php");
        include("vue/menu.html");
        include("vue/lesObjets.php");
        include("vue/fin.html");
    }
}
