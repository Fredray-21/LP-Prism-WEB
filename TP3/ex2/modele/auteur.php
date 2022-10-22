<?php
require_once("./config/connexion.php");

class Auteur
{
    public $numAuteur;
    public $nom;
    public $prenom;
    public $nationalite;
    public $anneeNaissance;


    public function __construct($numAuteur = NULL, $nom = NULL, $prenom = NULL, $nationalite = NULL, $anneeNaissance = NULL)
    {
        if (!is_null($numAuteur)) {
            $this->numAuteur = $numAuteur;
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->nationalite = $nationalite;
            $this->anneeNaissance = $anneeNaissance;
        }
    }

    public function getNumAuteur()
    {
        return $this->numAuteur;
    }

    public function setNumAuteur($numAuteur)
    {
        $this->numAuteur = $numAuteur;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getPrenom()
    {
        return $this->prenom;
    }

    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    public function getNationalite()
    {
        return $this->nationalite;
    }

    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;
    }

    public function getAnneeNaissance()
    {
        return $this->anneeNaissance;
    }

    public function setAnneeNaissance($anneeNaissance)
    {
        $this->anneeNaissance = $anneeNaissance;
    }


    // Méthode d'affichage
    public function Afficher()
    {
        return "Bonjour " . $this->nom . " " . $this->prenom;
    }


    public static function getAllAuteurs()
    {
        Connexion::connect();
        $requete = "SELECT * FROM auteur";
        $resultat = Connexion::pdo()->query($requete);
        $resultat->setFetchMode(PDO::FETCH_CLASS, 'Auteur');
        $auteurs = $resultat->fetchAll();
        Connexion::disconnect();
        return $auteurs;
    }


    public static function getAuteur($numAuteur)
    {
        Connexion::connect();
        $conn = Connexion::pdo();
        $requete = "SELECT * FROM auteur WHERE numAuteur = :numAuteur";
        $stmt = $conn->prepare($requete);
        $stmt->bindParam(":numAuteur", $numAuteur);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Auteur');
        $auteur = $stmt->fetch();
        Connexion::disconnect();
        return $auteur;
    }


    // function delete autheur where numAuteur = $numAuteur
    public static function deleteAuteur($numAuteur)
    {
        Connexion::connect();
        $conn = Connexion::pdo();
        //create requete with prepared statement
        $requete = "DELETE FROM auteur WHERE numAuteur = :numAuteur";
        $stmt = $conn->prepare($requete);
        $stmt->bindParam(":numAuteur", $numAuteur);
        $stmt->execute();
        Connexion::disconnect();
        return true;
    }

    public static function updateAuteur($numAuteur, $nom, $prenom, $nationalite, $anneeNaissance)
    {
        print_r($numAuteur);
        Connexion::connect();
        $conn = Connexion::pdo();
        //create requete with prepared statement
        $requete = "UPDATE auteur SET nom = :nom, prenom = :prenom, nationalite = :nationalite, anneeNaissance = :anneeNaissance WHERE numAuteur = :numAuteur";
        $stmt = $conn->prepare($requete);
        $stmt->bindParam(":numAuteur", $numAuteur);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":nationalite", $nationalite);
        $stmt->bindParam(":anneeNaissance", $anneeNaissance);
        $stmt->execute();
        Connexion::disconnect();
        return true;
    }

    public static function insertAuteur($nom, $prenom, $nationalite, $anneeNaissance)
    {
        Connexion::connect();
        $conn = Connexion::pdo();
        //create requete with prepared statement
        $requete = "INSERT INTO auteur (nom, prenom, nationalite, anneeNaissance) VALUES (:nom, :prenom, :nationalite, :anneeNaissance)";
        $stmt = $conn->prepare($requete);
        $stmt->bindParam(":nom", $nom);
        $stmt->bindParam(":prenom", $prenom);
        $stmt->bindParam(":nationalite", $nationalite);
        $stmt->bindParam(":anneeNaissance", $anneeNaissance);
        $stmt->execute();
        Connexion::disconnect();
        return true;
    }
}
