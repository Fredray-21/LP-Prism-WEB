<?php

class Livre extends Objet
{
    protected $numLivre;
    protected $titre;
    protected $anneeParution;
    protected $numGenre;
    protected static $objet = "Livre";
    protected static $cle = "numLivre";

    // method afficher
    public function afficher()
    {
        echo "<p class='ligne'>Livre $this->titre, paru en $this->anneeParution </p>";
    }

    public static function addLivre($titre, $anneeParution, $numGenre)
    {
        $req = "INSERT INTO Livre (titre,anneeParution,numGenre) VALUES (:titre,:anneeParution,:numGenre)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':anneeParution', $anneeParution);
        $stmt->bindParam(':numGenre', $numGenre);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function updateLivre($numLivre, $titre, $anneeParution, $numGenre)
    {
        $req = "UPDATE Livre SET titre=:titre, anneeParution=:anneeParution, numGenre=:numGenre WHERE numLivre=:numLivre";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numLivre', $numLivre);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':anneeParution', $anneeParution);
        $stmt->bindParam(':numGenre', $numGenre);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }


    public static function getAuteursByNumLivre($i)
    {
        $req = "SELECT * FROM Auteur WHERE numAuteur IN (SELECT numAuteur FROM estAuteurDe  WHERE numLivre = :numLivre)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numLivre', $i);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, 'Auteur');
        return $res;
    }

    public static function getNonAuteursByNumLivre($i)
    {
        $req = "SELECT * FROM Auteur WHERE numAuteur NOT IN (SELECT numAuteur FROM estAuteurDe WHERE numLivre = :numLivre)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numLivre', $i);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, 'Auteur');
        return $res;

    }

    public static function deleteAuteurForLivre($numLivre, $numAuteur)
    {
        $req = "DELETE FROM estAuteurDe WHERE numLivre=:numLivre AND numAuteur=:numAuteur";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numLivre', $numLivre);
        $stmt->bindParam(':numAuteur', $numAuteur);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function addAuteurForLivre($numLivre, $numAuteur)
    {
        $req = "INSERT INTO estAuteurDe (numLivre,numAuteur) VALUES (:numLivre,:numAuteur)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numLivre', $numLivre);
        $stmt->bindParam(':numAuteur', $numAuteur);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

}
