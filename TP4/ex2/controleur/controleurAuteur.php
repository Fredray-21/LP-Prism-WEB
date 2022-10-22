<?php
  require_once("modele/Auteur.php");

  class ControleurAuteur {

    public static function lireAuteurs() {
      $titre = "les auteurs";
      $tableau = Auteur::getAllAuteurs();
      $tableauAffichage = array();
      foreach($tableau as $auteur) {
        $numAuteur = $auteur->getNumAuteur();
        $nom = $auteur->getNom();
        $prenom = $auteur->getPrenom();
        $lienDetails = "<a class='bouton' href=\"routeur.php?controleur=controleurAuteur&action=lireAuteur&numAuteur=$numAuteur\"> détails </a>";
        $tableauAffichage[] = "<div class='ligne'><div>Auteur $prenom $nom</div><div> $lienDetails</div></div>";
      }
      include("vue/debut.php");
      include("vue/menu.html");
      include("vue/lesObjets.php");
      include("vue/fin.html");
    }

    public static function lireAuteur() {
      $titre = "un auteur";
      $numAuteur = $_GET["numAuteur"];
      $object = Auteur::getAuteurByNum($numAuteur);
      include("vue/debut.php");
      include("vue/menu.html");
      include("vue/lesObjets.php");
      include("vue/fin.html");
    }

  }

?>
