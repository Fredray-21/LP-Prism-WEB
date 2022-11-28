<?php
require_once("modele/Nationalite.php");

class ControleurNationalite extends ControleurObjet
{
    protected static $objet = "Nationalite";
    protected static $cle = "numNationalite";
    protected static $tableauChamps = array(
        "pays" => ["text", "Pays"],
        "abrege" => ["text", "Abrege"]
    );

}
