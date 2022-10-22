<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>Tableau des capitaux successifs</h1>
    <ul style="list-style-type: none;">
        <?php
        $capital = array(10000);
        $n = 11;
        for ($i = 1; $i < $n; $i++) {

            $old = $capital[$i - 1];
            $resultat = $old * (1 + 5 / 100);
            $capital[$i] = floor($resultat);
            echo  "<li>C[$i] {$capital[$i]} €</li><br>";;
        }
        ?>
    </ul>

</body>

</html>