<?php
class Objet
{
    public function get($attribut){
        return $this->$attribut;
    }
    public function set($attribut, $valeur){
        $this->$attribut = $valeur;
    }
}
