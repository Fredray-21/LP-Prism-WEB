<?php
class Auteur extends Objet
{
	// attributs
	protected $numAuteur;
	protected $nomAuteur;
	protected $prenomAuteur;
	protected $anneeNaissance;
	protected static $objet = "Auteur";
	protected static $cle = "numAuteur";
	
	// une methode d'affichage.
	public function afficher()
	{
		echo "<p class='ligne'>auteur $this->prenomAuteur $this->nomAuteur, né(e) en $this->anneeNaissance </p>";
	}
}
