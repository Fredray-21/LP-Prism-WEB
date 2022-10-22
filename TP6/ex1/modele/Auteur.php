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

	public static function addAuteur($n, $p, $a)
	{
		$req = "INSERT INTO Auteur (nomAuteur, prenomAuteur, anneeNaissance) VALUES (:nom_tag, :prenom_tag, :annee_tag)";
		$rep = Connexion::pdo()->prepare($req);
		$rep->bindParam(':nom_tag', $n);
		$rep->bindParam(':prenom_tag', $p);
		$rep->bindParam(':annee_tag', $a);

		try {
			$rep->execute();
			return true;
		} catch (PDOException $e) {
			echo "Erreur : " . $e->getMessage();
			return false;
		}
	}
}
