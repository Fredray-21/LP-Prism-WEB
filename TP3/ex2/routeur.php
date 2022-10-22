    <?php
    require_once("./modele/auteur.php");
    require_once("./config/connexion.php");
    $auteurs =  Auteur::getAllAuteurs();

    if (!empty($_GET["numAuteur"])) {
        $numAuteur = $_GET["numAuteur"];
        $auteur = Auteur::getAuteur($numAuteur);
        $textBTN = "Valider les modifications";
    } else {
        $numAuteur = "";
        $auteur = new Auteur();
        $textBTN = "Ajouter l'Auteur";
    }

    $name = $auteur->getNom();
    $prenom = $auteur->getPrenom();
    $nationalite = $auteur->getNationalite();
    $anneeNaissance = $auteur->getAnneeNaissance();

    if (!empty($_GET["numAuteur"])) {
        $action = "updateAuteur.php";
    } else {
        $action = "insertAuteur.php";
    }

    require_once("./vue/lesAuteurs.php");
    ?>

