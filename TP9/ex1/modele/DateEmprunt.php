<?php
class DateEmprunt extends Objet
{
    protected $numDateEmprunt;
    protected $dateEmprunt;
	protected static $objet = "DateEmprunt";
	protected static $cle = "numDateEmprunt";

    public function afficher()
    {
        echo "<p class='ligne'>DateEmprunt $this->dateEmprunt </p>";
    }
}
