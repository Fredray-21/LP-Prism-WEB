<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./config/style.css">
</head>

<body>
    <?php
    require_once("./modele/auteur.php");
    require_once("./config/connexion.php");
    ?>

    <table id="tableAuteurs">
        <tbody>
            <tr>
                <th>Num Auteur</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Nationalite</th>
                <th>AnneeNaissance</th>
            </tr>
            <?php
            foreach ($auteurs as $auteur) {
                echo "<tr>";
                echo "<td>" . $auteur->getNumAuteur() . "</td>";
                echo "<td>" . $auteur->getNom() . "</td>";
                echo "<td>" . $auteur->getPrenom() . "</td>";
                echo "<td>" . $auteur->getNationalite() . "</td>";
                echo "<td>" . $auteur->getAnneeNaissance() . "</td>";
                echo "<td><a class='bin' href='deleteAuteur.php?numAuteur=" . $auteur->getNumAuteur() . "'>🗑</a></td>";
                echo "<td><a href='routeur.php?numAuteur=" . $auteur->getNumAuteur() . "'>Update</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <br>
    <form action=<?php echo $action ?> method="post">
        <table>
            <tr>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Nationalite</th>
                <th>AnneeNaissance</th>
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