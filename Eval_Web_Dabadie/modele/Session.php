<?php

class Session
{
    public static function userConnected()
    {
        return isset($_SESSION['user']);
    }

    public static function adminConnected()
    {
        return isset($_SESSION['user']) && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
    }

    public static function userConnecting()
    {
        if (isset($_GET["action"]) && $_GET["action"] == "connecterClient") return true;
        return false;
    }

    public static function userCreating()
    {
        if (isset($_GET["action"]) && $_GET["action"] == "creerCompteClient") return true;
        return false;
    }

    public static function urlMenu()
    {
        return self::adminConnected() ? "vue/menuAdmin.php" : "vue/menuAdherent.php";
    }

}
