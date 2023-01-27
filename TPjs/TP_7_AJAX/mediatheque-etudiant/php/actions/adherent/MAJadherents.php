<?php
// 1. on récupère dans une variable PHP la chaîne de caractères représentant le tableau des adhérents
$adherents = $_GET['tabAdherents'];

// 2. on la décode de son format JSON, pour en faire un tableau PHP
$adherents = json_decode($adherents);

// 3. on efface tout d'abord tous les adhérents de la base de données
Adherent::deleteAllAdherents();

// 4. ensuite, pour chaque adhérent du tableau d'adhérents, on ajoute une entrée dans la table de données
foreach ($adherents as $adherent) {
    Adherent::addAdherent($adherent->numAdherent, $adherent->nom, $adherent->prenom);
}

// 5. enfin, pour vérification, on récupère tous les adhérents de la table de données
$adherents = Adherent::getAllAdherents();

// 6. puis on fait un echo de l'encodage json de ce tableau. Cet echo sera récupéré par la requête AJAX.
echo json_encode($adherents);

?>
