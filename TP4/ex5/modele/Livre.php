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
}
