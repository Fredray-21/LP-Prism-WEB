<?php

class Categorie extends Objet
{
    protected $numCategorie;
    protected $libelle;
    protected $nbLivresAutorises;
    protected static $objet = "Categorie";
    protected static $cle = "numCategorie";


    // method afficher
    public function afficher()
    {
        return "$this->libelle nbLivreAutorises: $this->nbLivresAutorises";
    }

    public static function addCategorie($libelle, $nbLivreAuthorises)
    {
        $req = "INSERT INTO Categorie (libelle,nbLivresAutorises) VALUES (:libelle,:nbLivresAutorises)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':libelle', $libelle);
        $stmt->bindParam(':nbLivresAutorises', $nbLivreAuthorises);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function updateCategorie($numCategorie, $libelle, $nbLivreAuthorises)
    {
        $req = "UPDATE Categorie SET libelle=:libelle,nbLivresAutorises=:nbLivresAutorises WHERE numCategorie=:numCategorie";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numCategorie', $numCategorie);
        $stmt->bindParam(':libelle', $libelle);
        $stmt->bindParam(':nbLivresAutorises', $nbLivreAuthorises);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}
