<form class="formulaire" action="index.php" method="get">
    <input type="hidden" name="controleur" value="Controleur<?= $table ?>">
    <input type="hidden" name="action" value="modifier<?= $table ?>">
    <input type="hidden" name="identifiant" value="<?= $tableauChamps["identifiant"] ?>">

    <?php
    $id = $tableauChamps["identifiant"];
    unset($tableauChamps["identifiant"]);
    foreach ($tableauChamps as $key => $value) {

        $type = $value[0];
        $label = $value[1];
        $valeur = $objet->get($key);

        echo "<label for='$key'>$label</label>";
        if ($valeur != $id) {
            echo "<input type='$type' name='$key' id='$key' value='$valeur'>";
        } else {
            echo "<input type='number' disabled name='$key' id='$key' value='$valeur'>";
        }
    }
    ?>
    <div>
        <button type="submit">Valider</button>
    </div>
</form>