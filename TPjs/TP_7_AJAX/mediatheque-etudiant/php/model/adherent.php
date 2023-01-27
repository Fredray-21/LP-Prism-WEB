<?php
class Adherent {

  public static function getAllAdherents() {
      try {
          // préparation de la requête
          $sql = "SELECT * FROM adherentMedJS";
          $req_prep = Connexion::pdo()->prepare($sql);
          $req_prep->execute();
          $req_prep->setFetchMode(PDO::FETCH_OBJ);
          $tabResults = $req_prep->fetchAll();
          // renvoi du tableau de résultats
          return $tabResults;
      } catch (PDOException $e) {
          echo $e->getMessage();
          die("Erreur lors de la recherche dans la base de données.");
      }
  }

  public static function addAdherent($numAdherent, $nom, $prenom) {
      try {
          // préparation de la requête
          $sql = "INSERT INTO adherentMedJS(`numAdherent`,`nom`,`prenom`) VALUES(:numA,:nom,:prenom)";
          $req_prep = Connexion::pdo()->prepare($sql);
          $valeurs = array("numA" => $numAdherent, "nom"=> $nom, "prenom" => $prenom);
          $req_prep->execute($valeurs);
      } catch (PDOException $e) {
          echo $e->getMessage();
          die("Erreur lors de la recherche dans la base de données.");
      }
  }

  public static function deleteAllAdherents() {
    try {
        // préparation de la requête
        $sql = "DELETE FROM adherentMedJS WHERE 1";
        $req_prep = Connexion::pdo()->prepare($sql);
        $req_prep->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la recherche dans la base de données.");
    }
  }

}

?>
