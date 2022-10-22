<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./config/style.css">
</head>

<?php require_once("./vue/navBar.html"); ?>

<body>
    <table id="tableAuteurs">
        <tbody>
            <?php if (count($auteurs) > 0) { ?>
                <tr>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Details</th>
                </tr>
                <?php foreach ($auteurs as $auteur) { ?>
                    <tr>
                        <td><?= $auteur->getNom() ?></td>
                        <td><?= $auteur->getPrenom() ?></td>
                        <td><a href='routeur.php?action=viewUnAuteur&numAuteur=<?= $auteur->getNumAuteur(); ?>'>View</a></td>
                    </tr>
            <?php
                }
            } else {
                echo "<tr>";
                echo "<td colspan='7'>Aucun auteur trouvé</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <form action="routeur.php<?php echo !empty($_GET['numAuteur']) ?  "?action=update" : "?action=insert" ?>" method="post">
    <table>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Nationalite</th>
            <th>Annee de Naissance</th>
        </tr>
        <tr>
            <input type="hidden" name="numAuteur" id="numAuteur" value=<?= $numAuteur ?>>
            <td><input type="text" name="nom" id="nom" value=<?= $name ?>></td>
            <td><input type="text" name="prenom" id="prenom" value=<?= $prenom ?>></td>
            <td><input type="text" name="nationalite" id="nationalite" value=<?= $nationalite ?>></td>
            <td><input type="text" name="anneeNaissance" id="anneeNaissance" value=<?= $anneeNaissance ?>></td>
        </tr>
    </table>
    <button class="btn-add" type="submit"><?php echo $textBTN ?></button>
    <button class="btn-clear" type="button" onclick="location.href = './routeur.php';">Clear</button>
</form>    
</body>

</html>