<?php
$table = static::$objet;
?>
<form class="formulaire" action="index.php" method="get">
    <input type="hidden" name="controleur" value="Controleur<?= $table ?>">
    <input type="hidden" name="action" value="creer<?= $table ?>">

    <?php

$tableauGenre = Genre::getAllObjects();
// error $value -> get(numGenre) -> undefined

    foreach (static::$tableauChamps as $champ => $type) {
        $label = $type[1];
        $type = $type[0];
        echo "<div class='row-form' ><label for='$champ'>$label</label>";

        if($type == "select"){
            echo "<select name='$champ'>";
            
            foreach ($tableauGenre as $key => $value) {
                echo "<option value='$key'>$value</option>";
            }
            echo "</select>";
        }else{
            echo "<input type='$type' name='$champ' id='$champ' placeholder='$label' required>";
        }
        echo "</div>";

    }
    echo "";
    ?>

    <div>
        <button type="submit">Créer</button>
    </div>
</form>