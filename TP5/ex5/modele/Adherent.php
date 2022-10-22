<?php
class Adherent  extends Objet
{

    protected $login;
    protected $mdp;
    protected $nomAdherent;
    protected $prenomAdherent;
    protected $email;
    protected $dateAdhesion;
    protected $numCategorie;
	protected static $objet = "Adherent";
	protected static $cle = "login";

    public function afficher()
    {
        echo "<p class='ligne'>Adherent $this->nomAdherent $this->prenomAdherent $this->email $this->dateAdhesion $this->numCategorie </p>";
    }
}
