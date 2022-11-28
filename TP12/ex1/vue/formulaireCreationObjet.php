<?php
$table = static::$objet;
?>
<form class="formulaire" action="index.php" method="get">
    <input type="hidden" name="controleur" value="Controleur<?= $table ?>">
    <input type="hidden" name="action" value="creerObjet">

    <?php
    foreach (static::$tableauChamps as $champ => $type) {
        $label = $type[1];
        $type = $type[0];
        echo "<div class='row-form' ><label for='$champ'>$label</label>";

        switch ($champ) {
            case "numGenre":
                $tableauGenres = Genre::getAllObjects();
                echo "<select name='$champ'>";
                foreach ($tableauGenres as $genre) {
                    $numGenre = $genre->get('numGenre');
                    $intitule = $genre->get('intitule');
                    echo "<option value='$numGenre'>$intitule</option>";
                }
                echo "</select>";
                break;
            case "numCategorie":
                $tableauCategories = Categorie::getAllObjects();
                echo "<select name='$champ'>";
                foreach ($tableauCategories as $categorie) {
                    $numCategorie = $categorie->get('numCategorie');
                    $libelle = $categorie->get('libelle');
                    echo "<option value='$numCategorie'>$libelle</option>";
                }
                echo "</select>";
                break;
            case "anneeNaissance":
                $d = date('Y');
                echo "<select name='$champ' required>";
                for ($i = 1900; $i <= $d; $i++) {
                    echo "<option value='$i'>$i</option>";
                }
                echo "</select>";
                break;
            default:
                echo "<input type='$type' name='$champ' required>";
        }

        echo "</div>";
    }
    ?>

    <div>
        <button type="submit">Créer</button>
    </div>
</form>