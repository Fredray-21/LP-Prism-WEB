<?php
class Categorie extends Objet
{
    protected $numCategorie;
    protected $libelle;
    protected $nbLivresAutorises;
    protected static $objet = "Categorie";
    protected static $cle = "numCategorie";


    public function afficher()
    {
        echo "<p class='ligne'>Categorie $this->libelle nbLivreAutorises: $this->nbLivresAutorises </p>";
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
}
