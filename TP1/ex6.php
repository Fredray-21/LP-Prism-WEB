<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<?php
echo "<pre>";
echo "Affichage de _GET";
print_r($_GET);
echo "<br>";

echo "Affichage des clées du tableau <br>";
print_r(array_keys($_GET));
echo "<br>";

$array_keys = array_keys($_GET);
echo "Nom présent :" . (in_array("nom", $array_keys) ? "oui" : "non") . "<br>";
echo "Prenom présent :" . (in_array("prenom", $array_keys) ? "oui" : "non") . "<br>";

echo "</pre>";
?>

</body>

</html>