<?php

class Adherent extends Objet
{
    protected $login;
    protected $mdp;
    protected $nomAdherent;
    protected $prenomAdherent;
    protected $email;
    protected $dateAdhesion;
    protected $numCategorie;
    protected $isAdmin;
    protected $chaineValidationEmail;

    protected static $objet = "Adherent";
    protected static $cle = "login";

    public function afficher()
    {
        echo "<p class='ligne'>Adherent $this->nomAdherent $this->prenomAdherent $this->email $this->dateAdhesion $this->numCategorie </p>";
    }

    public function isAdmin()
    {
        return $this->isAdmin == 1;
    }

    public function affichable()
    {
        return !$this->isAdmin;
    }

    public static function checkMDP($l, $m)
    {
        $req = "SELECT * FROM Adherent WHERE login = :login_tag AND mdp = :mdp_tag";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':login_tag', $l);
        $rep->bindParam(':mdp_tag', $m);
        $rep->execute();
        $rep->setFetchMode(PDO::FETCH_CLASS, 'Adherent');
        $adherent = $rep->fetch();

        if ($adherent != null) return true;
        return false;
    }

    public static function validateAccount($l, $ch)
    {
        $req = "SELECT * FROM Adherent WHERE login = :login_tag AND chaineValidationEmail = :chaine_tag";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':login_tag', $l);
        $rep->bindParam(':chaine_tag', $ch);
        $rep->execute();
        $rep->setFetchMode(PDO::FETCH_CLASS, 'Adherent');
        $adherent = $rep->fetch();

        if ($adherent != null) {
            $req = "UPDATE Adherent SET chaineValidationEmail = NULL WHERE login = :login_tag";
            $rep = Connexion::pdo()->prepare($req);
            $rep->bindParam(':login_tag', $l);
            $rep->execute();
            return true;
        }
        return false;
    }
}
