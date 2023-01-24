<div id="navigation">

    <!-- dropdown -->
    <div class="dropdown">
        <button class="dropbtn"><i class='bi bi-pencil'></i> Auteurs</button>
        <div class="dropdown-content">
            <a href="index.php?controleur=ControleurAuteur&action=lireObjets">Tous les auteurs</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn"><i class='bi bi-people'></i> Adherents</button>
        <div class="dropdown-content">
            <a href="index.php?controleur=ControleurAdherent&action=lireObjets">Tous les Adherents</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="dropbtn"><i class="bi bi-book"></i> Livres</button>
        <div class="dropdown-content">
            <a href="index.php?controleur=ControleurLivre&action=lireObjets">Tous les Livres</a>
        </div>
    </div>

    <?php
    if ($_SESSION["login"]) {
        $adherent = Client::getObjetById($_SESSION["login"]);
        $nom = $adherent->get("nomAdherent");
        $prenom = $adherent->get("prenomAdherent");
        ?>
        <div class="dropdown">
            <button class="dropbtn"><i class="bi bi-box-arrow-in-right"></i> <?= $nom ?> <?= $prenom ?> </button>
            <div class="dropdown-content">
                <a href='index.php?controleur=ControleurAdherent&action=deconnecterAdherent'><i
                            class='bi bi-box-arrow-in-right'></i> Se deconnecter</a>
            </div>
        </div>
        <?php
    }
    ?>


</div>

<div id="results">