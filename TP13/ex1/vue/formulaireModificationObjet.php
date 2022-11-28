<form class="formulaire" action="index.php" method="get">
    <input type="hidden" name="controleur" value="Controleur<?= $table ?>">
    <input type="hidden" name="action" value="modifierObjet">
    <input type="hidden" name="identifiant" value="<?= $tableauChamps["identifiant"] ?>">


    <?php
    unset($tableauChamps["identifiant"]);
    foreach ($tableauChamps as $champ => $type) {
        $label = $type[1];
        $type = $type[0];
        $valeur = $objet->get($champ);
        echo "<div class='row-form' ><label for='$champ'>$label</label>";
        switch ($champ) {
            case "numGenre":
                $tableauGenres = Genre::getAllObjects();
                echo "<select name='$champ'>";
                foreach ($tableauGenres as $genre) {
                    $numGenre = $genre->get('numGenre');
                    $intitule = $genre->get('intitule');

                    if ($numGenre == $valeur) {
                        echo "<option value='$numGenre' selected>$intitule</option>";
                    } else {
                        echo "<option value='$numGenre'>$intitule</option>";
                    }
                }
                echo "</select>";
                break;
            case "numCategorie":
                $tableauCategories = Categorie::getAllObjects();
                echo "<select name='$champ'>";
                foreach ($tableauCategories as $categorie) {
                    $numCategorie = $categorie->get('numCategorie');
                    $libelle = $categorie->get('libelle');
                    if ($numCategorie == $valeur) {
                        echo "<option value='$numCategorie' selected>$libelle</option>";
                    } else {
                        echo "<option value='$numCategorie'>$libelle</option>";
                    }
                }
                echo "</select>";
                break;
            case "anneeNaissance":
            case "anneeParution":
                $d = date('Y');
                echo "<select name='$champ'>";
                if ($valeur == null) {
                    echo "<option selected hidden disabled>Année non renseignée</option>";
                    for ($i = 1900; $i <= $d; $i++) {
                        if ($i == $valeur && $valeur != null) {
                            echo "<option value='$i' selected>$i</option>";
                        } else {
                            echo "<option value='$i'>$i</option>";
                        }
                    }
                } else {
                    for ($i = 1900; $i <= $d; $i++) {
                        if ($i == $valeur && $valeur != null) {
                            echo "<option value='$i' selected>$i</option>";
                        } else {
                            echo "<option value='$i'>$i</option>";
                        }
                    }
                }
                echo "</select>";
                break;
            default:
                echo "<input type='$type' name='$champ' value=$valeur required>";
        }

        echo "</div>";
    }

    ?>

    <div>
        <button type="submit">Modifier</button>
    </div>

</form>