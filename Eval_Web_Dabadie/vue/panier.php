<?php

if (!empty($tableauAffichage)) {

    foreach ($tableauAffichage as $article) {
        echo $article;
    }
    echo "<button class='bouton btn-green'>Passer la commande <i class='bi bi-cart-check'></i></button>";
} else {
    echo "<h1>Votre Panier est vide </h1>";
    echo "<a class='bouton btn-green' href='index.php'>Voir les Articles <i class='bi bi-shop'></i></a>";
}
?>






