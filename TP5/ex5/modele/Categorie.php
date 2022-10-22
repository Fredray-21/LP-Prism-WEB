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
}
