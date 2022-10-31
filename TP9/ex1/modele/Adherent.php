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
    protected $isAdmin;
    protected static $objet = "Adherent";
    protected static $cle = "login";

    public function afficher()
    {
        echo "<p class='ligne'>Adherent $this->nomAdherent $this->prenomAdherent $this->email $this->dateAdhesion $this->numCategorie </p>";
    }


    public static function addAdherent($l, $mdp, $e, $n, $p, $numCategorie)
    {
        $req = "INSERT INTO Adherent (login, mdp, nomAdherent,prenomAdherent,email, numCategorie ) VALUES (:login_tag, :mdp_tag, :nom_tag, :prenom_tag, :email_tag, :numCategorie_tag, :isAdmin_tag)";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':login_tag', $l);
        $rep->bindParam(':mdp_tag', $mdp);
        $rep->bindParam(':email_tag', $e);
        $rep->bindParam(':nom_tag', $n);
        $rep->bindParam(':prenom_tag', $p);
        $rep->bindParam(':numCategorie_tag', $numCategorie);
        $rep->bindParam(':isAdmin_tag', 0);


        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function updateAdherent($l, $mdp, $n, $p, $e, $numCategorie)
    {
        $req = "UPDATE Adherent SET mdp = :mdp_tag, nomAdherent = :nom_tag, prenomAdherent = :prenom_tag, email = :email_tag, numCategorie = :numCategorie_tag WHERE login = :login_tag";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':login_tag', $l);
        $rep->bindParam(':mdp_tag', $mdp);
        $rep->bindParam(':email_tag', $e);
        $rep->bindParam(':nom_tag', $n);
        $rep->bindParam(':prenom_tag', $p);
        $rep->bindParam(':numCategorie_tag', $numCategorie);

        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
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
}
