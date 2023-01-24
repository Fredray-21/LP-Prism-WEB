<?php

class Objet
{
    public function get($attribut)
    {
        return $this->$attribut;
    }

    public function set($attribut, $valeur)
    {
        $this->$attribut = $valeur;
    }

    public function __construct($attributs = NULL)
    {
        if (!is_null($attributs)) {
            foreach ($attributs as $attribut => $valeur) {
                $this->set($attribut, $valeur);
            }
        }
    }


    public static function getAllObjects()
    {
        $table = "eval_" . strtolower(static::$objet) . "s";
        $rep = Connexion::pdo()->query("SELECT * FROM " . $table);
        $rep->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $tab_objet = $rep->fetchAll();
        return $tab_objet;
    }

    //static function getObjetByCle($cle)
    public static function getObjetById($id)
    {
        $table = "eval_" . strtolower(static::$objet) . "s";
        $cle = static::$cle;
        $rep = Connexion::pdo()->prepare("SELECT * FROM " . $table . " WHERE " . $cle . " = :cle");
        $rep->bindParam(':cle', $id);
        $rep->execute();
        $rep->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $objet = $rep->fetch();
        return $objet;
    }


    // function deleteObjetById
    public static function deleteObjetById($id)
    {
        $table = "eval_" . strtolower(static::$objet) . "s";
        $cle = static::$cle;
        $req = "DELETE FROM " . $table . " WHERE " . $cle . " = :cle";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':cle', $id);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

}
