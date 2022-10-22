<?php

if (!empty($object)) {
	$object->afficher();
} else {
	foreach ($tableauAffichage as $ligne) {
		echo $ligne;
	}
}
