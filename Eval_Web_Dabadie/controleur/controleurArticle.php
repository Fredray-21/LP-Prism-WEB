<?php
require_once("./modele/Article.php");

class ControleurArticle extends ControleurObjet
{
    protected static $objet = "Article";
    protected static $cle = "code_article";
    protected static $tableauChamps = array(
        "code_article" => ["text", "Numéro article"],
        "libelle" => ["text", "Libelle"],
        "prix" => ["number", "Prix"],
    );

    public static function afficherFormulaireCreationArticle()
    {
        $titre = "Création d'un Article";

        include("vue/debut.php");
        include("vue/menu.php");
        include("vue/formulaireCreationAdherent.html");
        include("vue/fin.html");
    }

    public static function creerArticle()
    {
        $titre = "Création d'un Article";
        $tableau[] = $_GET["code_article"];
        $tableau[] = $_GET["libelle"];
        $tableau[] = $_GET["prix"];

        $result = Article::addArticle($tableau[0], $tableau[1], $tableau[2]);

        if ($result) {
            header("Location: index.php?controleur=ControleurArticle&action=lireObjets");
        } else {
            header("Location: index.php?controleur=ControleurArticle&action=afficherFormulaireCreationObjet");
        }
    }

    public static function addInPanier()
    {
        $titre = "Ajout d'un article au panier";
        $codeArticle = intval($_GET["code_article"]);
        $numClient = 1;

        $result = Client::addArticleInPanier($numClient, $codeArticle);
        if ($result) {
            header("Location: index.php?controleur=ControleurClient&action=afficherPanier");
        } else {
            header("Location: index.php?controleur=ControleurArticle&action=lireObjets");
        }
    }

    public static function removeInPanier()
    {
        $titre = "Suppression d'un article au panier";
        $id_panier = intval($_GET["code_panier"]);

        $result = Client::deleteArticleInPanier($id_panier);
        if ($result) {
            header("Location: index.php?controleur=ControleurClient&action=afficherPanier");
        } else {
            header("Location: index.php?controleur=ControleurArticle&action=lireObjets");
        }
    }

    public static function modifierArticle()
    {
        $titre = "Modification d'un Adherent";
        $tableau[] = $_GET["identifiant"];
        $tableau[] = $_GET["libelle"];
        $tableau[] = $_GET["prix"];

        $result = Article::updateArticle($tableau[0], $tableau[1], $tableau[2]);

        header("Location: index.php?controleur=ControleurArticle&action=lireObjets");
    }

}
