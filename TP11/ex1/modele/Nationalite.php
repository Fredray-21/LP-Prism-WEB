<?php

class Nationalite extends Objet
{
    protected $numNationalite;
    protected $pays;
    protected $abrege;
    protected static $objet = "Nationalite";
    protected static $cle = "numNationalite";


    public function afficher()
    {
        echo "<p class='ligne'>Nationalite $this->pays abrege: $this->abrege </p>";
    }
}
