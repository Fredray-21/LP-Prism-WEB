<form class="formulaire" action="routeur.php" method="get">
    <input type="hidden" name="controleur" value="Controleur<?= $table ?>">
    <input type="hidden" name="action" value="modifier<?= $table ?>">
    <input type="hidden" name="identifiant" value="<?= $tableauChamps["identifiant"] ?>">

    <?php
    foreach ($tableauChamps as $key => $value) {
        if ($key != "identifiant") {
            $type = $value[0];
            $label = $value[1];
            $valeur = $objet->get($key);
            echo "<label for='$key'>$label</label>";
            if ($table == "Adherent" && $key == "login") {
                echo "<input type='text' name='$key' id='$key' value='$valeur' disabled>";
            } else {
                echo "<input type='$type' name='$key' id='$key' value='$valeur'>";
            }
        }
    }
    ?>
    <div>
        <button type="submit">Valider</button>
    </div>
</form>