<?php
class Connexion
{
    static private $hostname = "localhost";
    static private $dbname = "fdabadi";
    static  private $user = "fdabadi";
    static private $password = "DVvs4vICJGb*kY,@-]Yh";

    static private $tabUTF8 = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

    static private $pdo;

    static public  function pdo()
    {
        return self::$pdo;
    }

    // function static de connexion qui initialise $pdo et lance la tentative de connexion
    static public function connect()
    {
        $h = self::$hostname;
        $d = self::$dbname;
        $u = self::$user;
        $p = self::$password;
        try {
            self::$pdo = new PDO("mysql:host=$h;dbname=$d", $u, $p, self::$tabUTF8);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Erreur de connexion à la base de données : " . $e->getMessage();
            die();
        }
    }
    // function static de déconnexion qui détruit $pdo
    static public function disconnect()
    {
        self::$pdo = null;
    }
}
