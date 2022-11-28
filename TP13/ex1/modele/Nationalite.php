<?php

class Nationalite extends Objet
{
    protected $numNationalite;
    protected $pays;
    protected $abrege;
    protected static $objet = "Nationalite";
    protected static $cle = "numNationalite";

    // method afficher
    public function afficher()
    {
        return "$this->pays abrege: $this->abrege";
    }
}
