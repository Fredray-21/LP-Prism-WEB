<?php

class Genre extends Objet
{
    protected $numGenre;
    protected $intitule;
    protected static $objet = "Genre";
    protected static $cle = "numGenre";

    // method afficher
    public function afficher()
    {
        return "$this->intitule";
    }

}
