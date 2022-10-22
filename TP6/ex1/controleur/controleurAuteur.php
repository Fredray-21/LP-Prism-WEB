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
    include("vue/formulaireCreationAuteur.html");
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
}
