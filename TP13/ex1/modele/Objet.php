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
        $table = static::$objet;
        $rep = Connexion::pdo()->query("SELECT * FROM " . $table);
        $rep->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $tab_objet = $rep->fetchAll();
        return $tab_objet;
    }

    //static function getObjetByCle($cle)
    public static function getObjetById($id)
    {
        $table = static::$objet;
        $cle = static::$cle;
        $rep = Connexion::pdo()->prepare("SELECT * FROM " . $table . " WHERE " . $cle . " = :cle");
        $rep->bindParam(':cle', $id);
        $rep->execute();
        $rep->setFetchMode(PDO::FETCH_CLASS, get_called_class());
        $objet = $rep->fetch();
        return $objet;
    }


    public static function requireAllControllers()
    {
        $dir = "controleur";
        $files = scandir($dir);
        foreach ($files as $file) {
            if (is_file($dir . "/" . $file)) {
                require_once($dir . "/" . $file);
            }
        }
    }

    // function deleteObjetById
    public static function deleteObjetById($id)
    {
        $table = static::$objet;
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

    public function affichable()
    {
        return true;
    }

    public static function addObjet($tableauDonnees)
    {
        $table = static::$objet;

        $req = "INSERT INTO $table (";
        $i = 0;
        foreach ($tableauDonnees as $key => $value) {
            if ($i < count($tableauDonnees) - 1) {  // if not last element
                $req .= $key . ", ";
            } else {
                $req .= $key . ") ";
            }
            $i++;
        }
        $req .= " VALUES (";
        $i = 0;
        foreach ($tableauDonnees as $key => $value) {
            if ($i < count($tableauDonnees) - 1) {  // if not last element
                $req .= ":" . $key . ", ";
            } else {
                $req .= ":" . $key . ")";
            }
            $i++;
        }

        $rep = Connexion::pdo()->prepare($req);
        try {
            $rep->execute($tableauDonnees);
            return true;
        } catch
        (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function updateObjet($tableauDonnees)
    {
        $table = static::$objet;
        $cle = static::$cle;

        $req = "UPDATE $table SET ";
        $i = 0;
        foreach ($tableauDonnees as $key => $value) {
            if ($key != $cle) {
                if ($i < count($tableauDonnees) - 1) {  // if not last element
                    $req .= $key . " = :" . $key . ", ";
                } else {
                    $req .= $key . " = :" . $key . " ";
                }
            }
            $i++;
        }
        $req .= " WHERE " . $cle . " = :$cle";

        $rep = Connexion::pdo()->prepare($req);
        try {
            $rep->execute($tableauDonnees);
            return true;
        } catch
        (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}
