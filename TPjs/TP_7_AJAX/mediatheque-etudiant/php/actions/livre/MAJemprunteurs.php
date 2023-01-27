<?php
// 1. on récupère dans une variable PHP la chaîne de caractères représentant le tableau des livres
$livres = $_GET['tabLivres'];

// 2. on la décode de son format JSON, pour en faire un tableau PHP
$livres = json_decode($livres);

// 3. on efface tout d'abord tous les livres de la base de données
Livre::deleteAllLivres();

// 4. ensuite, pour chaque livre du tableau de livres, on ajoute une entrée dans la table de données
foreach ($livres as $livre) {
    Livre::addLivre($livre->numLivre, $livre->titre, $livre->auteur, $livre->numEmprunteur, $livre->estEmprunte);
}

// 5. enfin, pour vérification, on récupère tous les livres de la table de données
$livres = Livre::getAllLivres();

// 6. puis on fait un echo de l'encodage json de ce tableau. Cet echo sera récupéré par la requête AJAX.
echo json_encode($livres);

?>
