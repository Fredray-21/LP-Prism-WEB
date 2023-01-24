<div id="navigation">

    <!-- dropdown -->
    <div class="dropdown">
        <button class="dropbtn"><i class='bi bi-pencil'></i> Les Articles</button>
        <div class="dropdown-content">
            <a href="index.php">Tous les Articles</a>
            <?php
            if (Session::adminConnected()) {
                echo "<a href='index.php?controleur=ControleurArticle&action=afficherFormulaireCreationObjet'>Créé un Article</a>";
            }
            ?>
        </div>
    </div>


    <a class="dropbtn" href="index.php?controleur=ControleurClient&action=afficherPanier"> Panier <i
                class='bi bi-cart'></i></a>

    <?php
    if ($_SESSION["user"]) :
        $client = Client::getObjetById($_SESSION["user"]);
        $nom = $client->get("nom");
        $prenom = $client->get("prenom");
        ?>
        <div class="dropdown">
            <button class="dropbtn"><i class="bi bi-box-arrow-in-right"></i> <?= $nom ?> <?= $prenom ?> </button>
            <div class="dropdown-content">
                <a href='index.php?controleur=ControleurClient&action=deconnecterClient'><i
                            class='bi bi-box-arrow-in-right'></i> Se deconnecter</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<!--    <div class="dropdown">-->
<!--        <button class="dropbtn"><i class='bi bi-people'></i> Adherents</button>-->
<!--        <div class="dropdown-content">-->
<!--            <a href="routeur.php?controleur=ControleurAdherent&action=lireObjets">Tous les Adherents</a>-->
<!--            <a href="routeur.php?controleur=ControleurAdherent&action=afficherFormulaireCreationObjet">Créé un-->
<!--                Adherents</a>-->
<!--        </div>-->
<!--    </div>-->

</div>
<div id="results">