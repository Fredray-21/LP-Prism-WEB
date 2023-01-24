<?php

class Article extends Objet
{
    protected $code_article;
    protected $libelle;
    protected $prix;
    protected static $objet = "Article";
    protected static $cle = "code_article";

    // method afficher
    public function afficher()
    {
        return "$this->libelle $this->prix";
    }


    public static function addArticle($code_article, $libelle, $prix)
    {
        $req = "INSERT INTO eval_articles (code_article, libelle, prix) VALUES (:code_article, :libelle, :prix)";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':code_article', $code_article);
        $rep->bindParam(':libelle', $libelle);
        $rep->bindParam(':prix', $prix);

        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function updateArticle($code_article, $libelle, $prix)
    {
        $req = "UPDATE eval_articles SET libelle = :libelle_tag, prix = :prix_tag WHERE code_article = :code_article_tag";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':code_article_tag', $code_article);
        $rep->bindParam(':libelle_tag', $libelle);
        $rep->bindParam(':prix_tag', $prix);
        
        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}
