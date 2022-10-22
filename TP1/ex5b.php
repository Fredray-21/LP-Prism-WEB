<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Calcul du taux minimum pour dépasser un seuil en un temps donné</h1>
    <form action="ex5b.php" method="GET">
        <input type="text" name="seuil" placeholder="Seuil"> <br>
        <input type="text" name="capitalInitial" placeholder="Capital Initial"> <br>
        <input type="text" name="nbAnnees" placeholder="Annees"> <br>
        <input type="text" name="precision" placeholder="Precision"> <br>
        <input type="submit">
    </form>

    <?php
    if (!empty($_GET["capitalInitial"]) && !empty($_GET["seuil"]) && !empty($_GET["nbAnnees"])  && !empty($_GET["precision"])) {
        $seuil = $_GET["seuil"];
        $capital = array($_GET["capitalInitial"]);
        $nbAnnees = $_GET["nbAnnees"];
        $precision = $_GET["precision"];
    } else {
        $seuil = 18000;
        $capital = array(10000);
        $nbAnnees = 10;
        $precision = 0.02;
    }

    $a = true;
    $taux = 0.1;
    $arrResult = [];
    while ($a) {

        for ($anne = 1; $anne <= $nbAnnees; $anne++) {
            $resultat = $capital[$anne - 1] * (1 + $taux / 100);
            $capital[$anne] = floor($resultat);
        }

        if ($capital[$nbAnnees] > $seuil) {
            $arrResult["taux"] = $taux;
            $arrResult["capital_debut_annee"] = $capital[$nbAnnees];;
            $a = false;
        } else {
            $taux = $taux + $precision;
        }
    }


    $lenString = strlen(explode(".", $precision)[1]);
    $view_taux_round =  round($arrResult["taux"], $lenString);
    ?>

    <p>Seuil à atteindre <?php echo $seuil ?> €</p>
    <p>Capital initial <?php echo $capital[0] ?> €</p>
    <p>Taux d'intérêts calculé : <?php echo $view_taux_round ?>%</p>
    <p>Capital en début d'année <?php echo $nbAnnees ?> : <?php echo $arrResult["capital_debut_annee"] ?> €</p>

</body>

</html>