<?php
class Genre  extends Objet
{
    protected $numGenre;
    protected $intitule;
	protected static $objet = "Genre";
	protected static $cle = "numGenre";

    public function afficher()
    {
        echo "<p class='ligne'>genre $this->intitule</p>";
    }

    public static function addGenre($intitule)
    {
        $req = "INSERT INTO Genre (intitule) VALUES (:intitule)";
        $stmt = Connexion::pdo()->prepare($req);
        $stmt->bindParam(':intitule', $intitule);
        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }


    public static function updateGenre($id, $intitule)
	{
		$req = "UPDATE Genre SET intitule = :intitule_tag WHERE numGenre = :id_tag";
		$rep = Connexion::pdo()->prepare($req);
		$rep->bindParam(':intitule_tag', $intitule);
		$rep->bindParam(':id_tag', $id);

		try {
			$rep->execute();
			return true;
		} catch (PDOException $e) {
			echo "Erreur : " . $e->getMessage();
			return false;
		}
	}

}
