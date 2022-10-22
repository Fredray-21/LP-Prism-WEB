<?php
class Auteur {

// attributs
	private $numAuteur;
	private $nom;
	private $prenom;
	private $anneeNaissance;

	// getter
	public function getNumAuteur() {return $this->numAuteur;}
	public function getNom() {return $this->nom;}
	public function getPrenom() {return $this->prenom;}
	public function getAnneeNaissance() {return $this->anneeNaissance;}

	// setter
	public function setNumAuteur($nu) {$this->numAuteur = $nu;}
	public function setNom($n) {$this->nom = $n;}
	public function setPrenom($p) {$this->prenom = $p;}
	public function setAnneeNaissance($a) {$this->anneeNaissance = $a;}

	// un constructeur
	public function __construct($nu = NULL, $n = NULL, $p = NULL, $a = NULL)  {
		if (!is_null($nu)) {
			$this->numAuteur = $nu;
			$this->nom = $n;
			$this->prenom = $p;
			$this->anneeNaissance = $a;
		}
	}

	// une methode d'affichage.
	public function afficher() {
		echo "<p>auteur $this->prenom $this->nom, né(e) en $this->anneeNaissance </p>";
	}

	// méthode static qui retourne les auteurs en un tableau d'objets
	public static function getAllAuteurs() {
		// écriture de la requête
		$requete = "SELECT * FROM Auteur;";
    // envoi de la requête et stockage de la réponse
		$resultat = Connexion::pdo()->query($requete);
    // traitement de la réponse
    $resultat->setFetchmode(PDO::FETCH_CLASS,'Auteur');
    $tableau = $resultat->fetchAll();
		return $tableau;
	}

	// méthode static qui retourne un auteur identifié par son numAuteur
	public static function getAuteurByNum($numAuteur) {
		// écriture de la requête
		$requetePreparee = "SELECT * FROM Auteur WHERE numAuteur = :num_tag;";
		$req_prep = Connexion::pdo()->prepare($requetePreparee);
		// le tableau des valeurs
		$valeurs = array("num_tag" => $numAuteur);
		try {
			// envoi de la requête
			$req_prep->execute($valeurs);
			// traitement de la réponse
	    $req_prep->setFetchmode(PDO::FETCH_CLASS,'Auteur');
			// récupération de l'auteur
			$a = $req_prep->fetch();
			// retour
			return $a;
		} catch(PDOException $e) {
			echo $e->getMessage();
		}
	}

}
?>
