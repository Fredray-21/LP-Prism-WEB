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

}
