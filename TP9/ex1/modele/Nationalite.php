<?php
class Nationalite extends Objet
{
    protected $numNationalite;
    protected $pays;
    protected $abrege;
    protected static $objet = "Nationalite";
    protected static $cle = "numNationalite";


    public function afficher()
    {
        echo "<p class='ligne'>Nationalite $this->pays abrege: $this->abrege </p>";
    }

    public static function addNationalite($pays, $abrege)
    {
        $req = "INSERT INTO Nationalite (pays,abrege) VALUES (:pays,:abrege)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':pays', $pays);
        $stmt->bindParam(':abrege', $abrege);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    public static function updateNationalite($numNationalite, $pays, $abrege)
    {
        $req = "UPDATE Nationalite SET pays=:pays,abrege=:abrege WHERE numNationalite=:numNationalite";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':numNationalite', $numNationalite);
        $stmt->bindParam(':pays', $pays);
        $stmt->bindParam(':abrege', $abrege);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }



}
