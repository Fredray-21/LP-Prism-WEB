<?php
class Categorie
{
    private $numCategorie;
    private $libelle;
    private $nbLivreAutorises;

    public function __construct($numCategorie = NULL, $libelle = NULL, $nbLivreAutorises = NULL)
    {
        if (!is_null($numCategorie)) {
            $this->numCategorie = $numCategorie;
            $this->libelle = $libelle;
            $this->nbLivreAutorises = $nbLivreAutorises;
        }
    }

    public function getNumCategorie()
    {
        return $this->numCategorie;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function getNbLivreAutorises()
    {
        return $this->nbLivreAutorises;
    }

    public function setNumCategorie($numCategorie)
    {
        $this->numCategorie = $numCategorie;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }

    public function setNbLivreAutorises($nbLivreAutorises)
    {
        $this->nbLivreAutorises = $nbLivreAutorises;
    }

    public function afficher()
    {
        echo "<p>Categorie $this->libelle nbLivreAutorises: $this->nbLivreAutorises </p>";
    }
}
