<?php

class Livre extends Objet
{
    private $numLivre;
    private $titre;
    private $anneeParution;
    private $numGenre;

    // constructor
    public function __construct($numLivre = NULL, $titre = NULL, $anneeParution = NULL, $numGenre = NULL)
    {
        if (!is_null($numLivre)) {
            $this->numLivre = $numLivre;
            $this->titre = $titre;
            $this->anneeParution = $anneeParution;
            $this->numGenre = $numGenre;
        }
    }

    // all getters and setters
    public function getNumLivre()
    {
        return $this->numLivre;
    }
    public function getTitre()
    {
        return $this->titre;
    }
    public function getAnneeParution()
    {
        return $this->anneeParution;
    }
    public function getNumGenre()
    {
        return $this->numGenre;
    }
    public function setNumLivre($numLivre)
    {
        $this->numLivre = $numLivre;
    }
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }
    public function setAnneeParution($anneeParution)
    {
        $this->anneeParution = $anneeParution;
    }
    public function setNumGenre($numGenre)
    {
        $this->numGenre = $numGenre;
    }
    // method afficher
    public function afficher()
    {
        echo "<p>Livre $this->titre, paru en $this->anneeParution </p>";
    }

    // method getLivrebynum
    public static function getLivrebynum($numLivre)
    {
        $sql = "SELECT * FROM Livre WHERE numLivre=:numLivre";
        $requete = Connexion::pdo()->prepare($sql);
        $requete->bindParam(':numLivre', $numLivre);
        $requete->execute();
        $resultat = $requete->fetch(PDO::FETCH_OBJ);
        $requete->closeCursor();
        if ($resultat) {
            return new Livre($resultat->numLivre, $resultat->titre, $resultat->anneeParution, $resultat->numGenre);
        } else {
            return false;
        }
    }

    //getAllLivre
    public static function getAllLivre()
    {
        $sql = "SELECT * FROM Livre";
        $requete = Connexion::pdo()->prepare($sql);
        $requete->execute();
        $resultat = $requete->fetchAll(PDO::FETCH_OBJ);
        $requete->closeCursor();
        $tableau = [];
        foreach ($resultat as $unLivre) {
            $tableau[] = new Livre($unLivre->numLivre, $unLivre->titre, $unLivre->anneeParution, $unLivre->numGenre);
        }
        return $tableau;
    }
}
