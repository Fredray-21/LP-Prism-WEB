    <?php
    require_once("./controleur/controleurAuteur.php");

    if (!empty($_GET['action']) && $_GET['action'] == "viewUnAuteur") {
        controleurAuteur::lireUnAuteur();
    } else {
        controleurAuteur::lireAuteurs();
    }
    ?>

