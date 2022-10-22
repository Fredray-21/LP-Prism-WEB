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


    public static function addAdherent($l, $mdp, $e, $n, $p, $numCategorie)
    {
        $req = "INSERT INTO Adherent (login, mdp, nomAdherent,prenomAdherent,email, numCategorie ) VALUES (:login_tag, :mdp_tag, :nom_tag, :prenom_tag, :email_tag, :numCategorie_tag)";
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
}
