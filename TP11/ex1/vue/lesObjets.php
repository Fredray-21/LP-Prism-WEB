<?php

if (!empty($object)) {
	$object->afficher();
} else {
	echo "<h1>".ucfirst($titre)."</h1>";
	foreach ($tableauAffichage as $ligne) {
		echo $ligne;
	}
}
