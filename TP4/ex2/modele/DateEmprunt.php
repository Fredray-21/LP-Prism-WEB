<?php
class DateEmprunt
{

    private $numDateEmprunt;
    private $dateEmprunt;

    public function __construct($numDateEmprunt = NULL, $dateEmprunt = NULL)
    {
        if (!is_null($numDateEmprunt)) {
            $this->numDateEmprunt = $numDateEmprunt;
            $this->dateEmprunt = $dateEmprunt;
        }
    }

    public function getNumDateEmprunt()
    {
        return $this->numDateEmprunt;
    }
    public function getDateEmprunt()
    {
        return $this->dateEmprunt;
    }
    public function setNumDateEmprunt($numDateEmprunt)
    {
        $this->numDateEmprunt = $numDateEmprunt;
    }
    public function setDateEmprunt($dateEmprunt)
    {
        $this->dateEmprunt = $dateEmprunt;
    }

    public function afficher()
    {
        echo "<p>DateEmprunt $this->dateEmprunt </p>";
    }
}
