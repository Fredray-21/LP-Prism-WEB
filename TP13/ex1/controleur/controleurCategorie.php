<?php
require_once("modele/Categorie.php");

class ControleurCategorie extends ControleurObjet
{
    protected static $objet = "Categorie";
    protected static $cle = "numCategorie";
    protected static $tableauChamps = array(
        "libelle" => ["text", "Libelle"],
        "nbLivresAutorises" => ["number", "Nombre de livres autorises"]
    );

}
