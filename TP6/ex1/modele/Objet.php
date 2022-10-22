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

}
