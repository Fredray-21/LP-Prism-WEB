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
            <tr>
                <th>Num Auteur</th>
                <th>Nom</th>
                <th>Prenom</th>
                <th>Nationalite</th>
                <th>Annee de Naissance</th>
            </tr>
            <tr>
                <td><?= $auteur->getNumAuteur() ?></td>
                <td><?= $auteur->getNom() ?></td>
                <td><?= $auteur->getPrenom() ?></td>
                <td><?= $auteur->getNationalite() ?></td>
                <td><?= $auteur->getAnneeNaissance() ?></td>
                <td><a class='bin' href='routeur.php?action=delete&numAuteur=<?= $auteur->getNumAuteur() ?>'>🗑</a></td>
                <td><a href='routeur.php?&numAuteur=<?= $auteur->getNumAuteur() ?>'>Update</a></td>
            </tr>
        </tbody>
    </table>
    

    <a href="routeur.php" id="btn-back">Retour</a>
</body>

</html>