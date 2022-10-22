<?php

class Livre
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
}
