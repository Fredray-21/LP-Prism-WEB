<?php
class Genre
{
    // attributs
    private $numGenre;
    private $intitule;
    // getter
    public function getNumGenre()
    {
        return $this->numGenre;
    }
    public function getIntitule()
    {
        return $this->intitule;
    }
    // setter
    public function setNumGenre($nu)
    {
        $this->numGenre = $nu;
    }
    public function setIntitule($l)
    {
        $this->intitule = $l;
    }
    // un constructeur
    public function __construct($numGenre = NULL, $intitule = NULL)
    {
        if (!is_null($numGenre)) {
            $this->numGenre = $numGenre;
            $this->intitule = $intitule;
        }
    }
    // une methode d'affichage.
    public function afficher()
    {
        echo "<p>genre $this->intitule</p>";
    }
}
