<?php

class Session
{
    public static function userConnected()
    {
        return isset($_SESSION['login']);
    }

    public static function adminConnected()
    {
        return isset($_SESSION['login']) && isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1;
    }

    public static function userConnecting()
    {
        if (isset($_GET["action"]) && $_GET["action"] == "connecterAdherent") return true;
        return false;
    }

    public static function urlMenu()
    {
        return self::adminConnected() ? "vue/menuAdmin.php" : "vue/menuAdherent.php";
    }
}
