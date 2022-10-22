<?php

class Nationalite
{
    private $numNationalite;
    private $pays;
    private $abrege;

    public function __construct($numNationalite = NULL, $pays = NULL, $abrege = NULL)
    {
        if (!is_null($numNationalite)) {
            $this->numNationalite = $numNationalite;
            $this->pays = $pays;
            $this->abrege = $abrege;
        }
    }

    public function getNumNationalite()
    {
        return $this->numNationalite;
    }
    public function getPays()
    {
        return $this->pays;
    }
    public function getAbrege()
    {
        return $this->abrege;
    }
    public function setNumNationalite($numNationalite)
    {
        $this->numNationalite = $numNationalite;
    }
    public function setPays($pays)
    {
        $this->pays = $pays;
    }
    public function setAbrege($abrege)
    {
        $this->abrege = $abrege;
    }

    public function afficher()
    {
        echo "<p>Nationalite $this->pays abrege: $this->abrege </p>";
    }
}
