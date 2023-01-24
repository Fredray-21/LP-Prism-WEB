<?php
require_once("modele/Genre.php");

class ControleurGenre extends ControleurObjet
{
    protected static $objet = "Genre";
    protected static $cle = "numGenre";
    protected static $tableauChamps = array(
        "intitule" => ["text", "Intitule"]
    );

}