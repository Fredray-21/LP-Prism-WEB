<?php
class Livre {

  public static function getAllLivres() {
      try {
          $sql = "SELECT * FROM livreMedJS";
          $req_prep = Connexion::pdo()->prepare($sql);
          $req_prep->execute();
          $req_prep->setFetchMode(PDO::FETCH_OBJ);
          $tabResults = $req_prep->fetchAll();
          return $tabResults;
      } catch (PDOException $e) {
          echo $e->getMessage();
          die("Erreur lors de la recherche dans la base de données.");
      }
  }

  public static function addLivre($numLivre, $titre, $auteur, $numEmprunteur, $estEmprunte) {
      try {
          // préparation de la requête
          $sql = "INSERT INTO livreMedJS(`numLivre`,`titre`,`auteur`,`numEmprunteur`,`estEmprunte`) VALUES(:numL,:titre,:auteur,:numE,:estEmp)";
          $req_prep = Connexion::pdo()->prepare($sql);
          $valeurs = array("numL" => $numLivre, "titre"=> $titre, "auteur" => $auteur, "numE" => $numEmprunteur, "estEmp" => $estEmprunte);
          $req_prep->execute($valeurs);
      } catch (PDOException $e) {
          echo $e->getMessage();
          die("Erreur lors de la recherche dans la base de données.");
      }
  }

  public static function deleteAllLivres() {
    try {
        // préparation de la requête
        $sql = "DELETE FROM livreMedJS WHERE 1";
        $req_prep = Connexion::pdo()->prepare($sql);
        $req_prep->execute();
    } catch (PDOException $e) {
        echo $e->getMessage();
        die("Erreur lors de la recherche dans la base de données.");
    }
  }
}

?>
