<?php
class Adherent  extends Objet
{

    private $login;
    private $mdp;
    private $nomAdherent;
    private $prenomAdherent;
    private $email;
    private $dateAdhesion;
    private $numCategorie;

    public function __construct($login = NULL, $mdp = NULL, $nomAdherent = NULL, $prenomAdherent = NULL, $email = NULL, $dateAdhesion = NULL, $numCategorie = NULL)
    {
        if (!is_null($login)) {
            $this->login = $login;
            $this->mdp = $mdp;
            $this->nomAdherent = $nomAdherent;
            $this->prenomAdherent = $prenomAdherent;
            $this->email = $email;
            $this->dateAdhesion = $dateAdhesion;
            $this->numCategorie = $numCategorie;
        }
    }

   
    public function getEmail()
    {
        return $this->email;
    }

    public function getDateAdhesion()
    {
        return $this->dateAdhesion;
    }

    public function getNumCategorie()
    {
        return $this->numCategorie;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function setMdp($mdp)
    {
        $this->mdp = $mdp;
    }

    public function setNomAdherent($nomAdherent)
    {
        $this->nomAdherent = $nomAdherent;
    }

    public function setPrenomAdherent($prenomAdherent)
    {
        $this->prenomAdherent = $prenomAdherent;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setDateAdhesion($dateAdhesion)
    {
        $this->dateAdhesion = $dateAdhesion;
    }

    public function setNumCategorie($numCategorie)
    {
        $this->numCategorie = $numCategorie;
    }

    public function afficher()
    {
        echo "<p>Adherent $this->nomAdherent $this->prenomAdherent $this->email $this->dateAdhesion $this->numCategorie </p>";
    }

    //get all
    public static function getAllAdherent()
    {
        $rep = Connexion::pdo()->query("SELECT * FROM Adherent");
        $rep->setFetchMode(PDO::FETCH_CLASS, 'Adherent');
        $tab_adherent = $rep->fetchAll();
        return $tab_adherent;
    }

    public static function getAdherentByLogin($login)
    {
        $rep = Connexion::pdo()->prepare("SELECT * FROM Adherent WHERE login = :login");
        $rep->bindParam(':login', $login);
        $rep->execute();
        $rep->setFetchMode(PDO::FETCH_CLASS, 'Adherent');
        $adherent = $rep->fetch();
        return $adherent;
    }
}
