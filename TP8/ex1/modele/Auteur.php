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

    // method afficher
    public function afficher()
    {
        return "$this->prenomAuteur $this->nomAuteur, né(e) en $this->anneeNaissance";
    }

    public static function addAuteur($n, $p, $a)
    {
        $req = "INSERT INTO Auteur (nomAuteur, prenomAuteur, anneeNaissance) VALUES (:nom_tag, :prenom_tag, :annee_tag)";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':nom_tag', $n);
        $rep->bindParam(':prenom_tag', $p);
        $rep->bindParam(':annee_tag', $a);

        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function updateAuteur($n, $p, $a, $id)
    {
        $req = "UPDATE Auteur SET nomAuteur = :nom_tag, prenomAuteur = :prenom_tag, anneeNaissance = :annee_tag WHERE numAuteur = :id_tag";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':nom_tag', $n);
        $rep->bindParam(':prenom_tag', $p);
        $rep->bindParam(':annee_tag', $a);
        $rep->bindParam(':id_tag', $id);

        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
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
