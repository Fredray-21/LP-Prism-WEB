<?php
require_once("./modele/Adherent.php");

class ControleurAdherent extends ControleurObjet
{
    protected static $objet = "Adherent";
    protected static $cle = "login";
    protected static $tableauChamps = array(
        "login" => ["text", "Login"],
        "mdp" => ["text", "Mots de passe"],
        "nomAdherent" => ["text", "Nom"],
        "prenomAdherent" => ["text", "Prénom"],
        "email" => ["text", "Email"],
        "numCategorie" => ["number", "Numéro de catégorie"],
    );

    public static function afficherFormulaireCreationAdherent()
    {
        $titre = "Création d'un Adherent";

        include("vue/debut.php");
        include(Session::urlMenu());
        include("vue/formulaireCreationAdherent.html");
        include("vue/fin.html");
    }

    public static function afficherFormulaireConnexion()
    {
        $titre = "Formulaire de connexion/inscription";

        include("vue/debut.php");
        include("vue/formulaireConnexion.html");
        include("vue/fin.html");
    }

    public static function connecterAdherent()
    {
        $login = $_GET["login"];
        $password = $_GET["password"];
        $result = Adherent::checkMDP($login, $password);
        $adherent = Adherent::getObjetById($login);
        $validationEmail = "non";
        if ($adherent) {
            $validationEmail = $adherent->get("chaineValidationEmail");
        }

        if ($result && $validationEmail == null) {
            $_SESSION["login"] = $login;
            $_SESSION["isAdmin"] = $adherent->isAdmin();
            self::lireObjets();
        } else {
            self::afficherFormulaireConnexion();
        }
    }

    public static function deconnecterAdherent()
    {
        if (Session::userConnected()) {
            session_unset();
            session_destroy();
            setcookie(session_name(), '', time() - 1);
            self::afficherFormulaireConnexion();
        } else {
            self::lireObjets();
        }
    }

    public static function creerCompteAdherent()
    {
        $titre = "Création d'un compte Adherent";
        $login = $_GET["login"];
        $password = $_GET["password"];
        $nom = $_GET["nom"];
        $prenom = $_GET["prenom"];
        $email = $_GET["email"];
        $ch = bin2hex(openssl_random_pseudo_bytes(16));

        $lien = "https://webdev.iut-orsay.fr/~fdabadi/LP/TP/TP10/ex1/index.php?";
        $lien .= "controleur=ControleurAdherent&action=validerCompteAdherent&login=$login&chaineValidationEmail=$ch";
        $destinataire = $email;
        $sujet = "Validation de votre compte";
        $message = "<html><head><meta charset='utf-8'><title>$sujet</title></head></head><body>";
        $message .= "<p>Bonjour $prenom $nom, voici un lien pour valider la création de votre compte associé au login $login : </p>";
        $message .= "<a style='text-decoration:underline; color:blue;' href='$lien' target='_blank' >Valider le compte de $login</a>";
        $message .= "</body></html>";
        $entete = [
            "MIME-Version: 1.0",
            "Content-type: text/html; charset=utf-8",
            "From: webmaster@bibliotheque2022.com",
            "Reply-To: $email",
            "X-Mailer: PHP/" . phpversion()
        ];
        //mail($destinataire, $sujet, $message, implode("\r\n", $entete));

        Client::addObjet(
            ["login" => $login,
                "mdp" => $password,
                "nomAdherent" => $nom,
                "prenomAdherent" => $prenom,
                "email" => $email,
                "dateAdhesion" => date("Y-m-d"),
                "numCategorie" => 1,
                "isAdmin" => 0,
                "chaineValidationEmail" => $ch]
        );

        include("vue/debut.php");
        include("vue/notificationLienValidation.html");
        include("vue/fin.html");
    }

    public static function validerCompteAdherent()
    {
        $titre = "Validation d'un compte Adherent";
        $login = $_GET["login"];
        $ch = $_GET["chaineValidationEmail"];
        $validationEmail = Client::validateAccount($login, $ch);
        if ($validationEmail) {
            include("vue/debut.php");
            include("vue/compteValide.html");
            include("vue/fin.html");
        } else {
            echo "Erreur de validation";
        }
    }
}
