<?php

class Client extends Objet
{
    protected $num_client;
    protected $nom;
    protected $prenom;
    protected $email;
    protected $tel;
    protected $password;
    protected $isAdmin;
    protected static $objet = "Client";
    protected static $cle = "num_client";

    // method afficher
    public function afficher()
    {
        return "$this->nom $this->prenom $this->email $this->tel";
    }

    public function isAdmin()
    {
        return $this->isAdmin == 1;
    }

    public static function addClient($num_client, $nom, $prenom, $email, $tel, $password)
    {
        $req = "INSERT INTO eval_clients (num_client, nom, prenom,email,tel, password) VALUES (:num_client, :nom, :prenom, :email, :tel, :password)";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':num_client', $num_client);
        $rep->bindParam(':nom', $nom);
        $rep->bindParam(':prenom', $prenom);
        $rep->bindParam(':email', $email);
        $rep->bindParam(':tel', $tel);
        $rep->bindParam(':password', $password);

        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function updateClient($num_client, $nom, $prenom, $email, $tel, $password)
    {
        $req = "UPDATE eval_clients SET nom = :nom_tag, prenom = :prenom_tag, email = :email_tag, tel = :tel_tag, password = :password_tag WHERE num_client = :num_client_tag";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':num_client_tag', $num_client);
        $rep->bindParam(':nom_tag', $nom);
        $rep->bindParam(':prenom_tag', $prenom);
        $rep->bindParam(':email_tag', $email);
        $rep->bindParam(':tel_tag', $tel);
        $rep->bindParam(':password_tag', $password);

        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function addArticleInPanier($num_client, $code_article)
    {
        $req = "INSERT INTO eval_panier (num_client, code_article) VALUES (:num_client, :code_article)";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':num_client', $num_client);
        $rep->bindParam(':code_article', $code_article);

        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function getPanier($code_client)
    {
        $req = "SELECT * FROM eval_panier WHERE num_client = :num_client";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':num_client', $code_client);
        $rep->execute();
        $result = $rep->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public static function deleteArticleInPanier($id_panier)
    {
        $req = "DELETE FROM eval_panier WHERE id = :id_panier";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':id_panier', $id_panier);

        try {
            $rep->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function checkMDP($l, $m)
    {
        $req = "SELECT * FROM eval_clients WHERE num_client = :num_client AND password = :mdp_tag";
        $rep = Connexion::pdo()->prepare($req);
        $rep->bindParam(':num_client', $l);
        $rep->bindParam(':mdp_tag', $m);
        $rep->execute();
        $rep->setFetchMode(PDO::FETCH_CLASS, 'Client');
        $adherent = $rep->fetch();

        if ($adherent != null) return true;
        return false;
    }

    //static function getObjetByCle($cle)
    public static function getClientByEmail($email)
    {
        $table = "eval_" . strtolower(static::$objet) . "s";
        $rep = Connexion::pdo()->prepare("SELECT * FROM " . $table . " WHERE email= :cle");
        $rep->bindParam(':cle', $email);
        $rep->execute();
        $rep->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $objet = $rep->fetch();
        return $objet;
    }


}
