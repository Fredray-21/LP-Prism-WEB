<?php

class Auteur extends Objet
{
    // attributs
    protected $numAuteur;
    protected $nomAuteur;
    protected $prenomAuteur;
    protected $anneeNaissance;
    protected static $objet = "Auteur";
    protected static $cle = "numAuteur";

    // une methode d'affichage.
    public function afficher()
    {
        echo "<p class='ligne'>auteur $this->prenomAuteur $this->nomAuteur, né(e) en $this->anneeNaissance </p>";
    }

    public static function getNationaliteByNumAuteur($i)
    {
        $req = "SELECT * FROM Nationalite WHERE numNationalite IN (SELECT numNationalite FROM estDeNationalite WHERE numAuteur = :numAuteur)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numAuteur', $i);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, 'Nationalite');
        return $res;
    }


    public static function getNonNationaliteByNumAuteur($i)
    {
        $req = "SELECT * FROM Nationalite WHERE numNationalite NOT IN (SELECT numNationalite FROM estDeNationalite WHERE numAuteur = :numAuteur)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numAuteur', $i);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_CLASS, 'Nationalite');
        return $res;
    }

    public static function deleteNationaliteForAuteur($numAuteur, $numNationalite)
    {
        $req = "DELETE FROM estDeNationalite WHERE numAuteur=:numAuteur AND numNationalite=:numNationalite";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numAuteur', $numAuteur);
        $stmt->bindParam(':numNationalite', $numNationalite);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function addNationaliteForAuteur($numAuteur, $numNationalite)
    {
        $req = "INSERT INTO estDeNationalite (numAuteur,numNationalite) VALUES (:numAuteur,:numNationalite)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numAuteur', $numAuteur);
        $stmt->bindParam(':numNationalite', $numNationalite);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}
