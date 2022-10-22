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
}
