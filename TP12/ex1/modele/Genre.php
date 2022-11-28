<?php

class Genre extends Objet
{
    protected $numGenre;
    protected $intitule;
    protected static $objet = "Genre";
    protected static $cle = "numGenre";

    public function afficher()
    {
        echo "<p class='ligne'>genre $this->intitule</p>";
    }

}
