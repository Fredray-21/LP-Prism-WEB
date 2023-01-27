<?php

class Modele {

    public static function select($lettre,$type) {
        try {
            // préparation de la requête
            $sql = "SELECT * FROM verbes WHERE libelle LIKE :name_tag LIMIT 50";
            $req_prep = Connexion::pdo()->prepare($sql);
            // préparation du tag en fonction du type de recherche (par initiale ou par séquence)
            // - par initiale : "$lettre%"
            // - par séquence : "%$lettre%"
            $l = "$lettre%";
            if ($type == "seq")
              $l = "%$lettre%";
            $values = array("name_tag" => $l);
            // exécution
            $req_prep->execute($values);
            $tabResults = $req_prep->fetchAll();
            // tableau résultat retourné
            return $tabResults;
        } catch (PDOException $e) {
            echo $e->getMessage();
            die("Erreur lors de la recherche dans la base de données.");
        }
    }

}
