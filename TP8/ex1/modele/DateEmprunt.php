<?php

class DateEmprunt extends Objet
{
    protected $numDateEmprunt;
    protected $dateEmprunt;
    protected static $objet = "DateEmprunt";
    protected static $cle = "numDateEmprunt";

    // method afficher
    public function afficher()
    {
        return "$this->dateEmprunt";
    }
}
