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

    public static function afficherFormulaireModificationObjet()
    {
        // On récupère l'objet à modifier
        $table = static::$objet;
        $cle = static::$cle;
        $objet = $table::getObjetById($_GET[$cle]);

        // On récupère les champs de l'objet
        $tableauChamps = static::$tableauChamps;
        $tableauChamps["identifiant"] = $_GET[$cle];

        // On récupère le titre de la page
        $titre = "Modification d'un " . static::$objet;

        // On affiche la page
        include("vue/debut.php");
        include(Session::urlMenu());
        include("vue/formulaireModificationObjet.php");
        include("vue/fin.html");
    }

    public static function modifierAdherent()
    {
        $titre = "Modification d'un Adherent";
        $tableau[] = $_GET["identifiant"];
        $tableau[] = $_GET["mdp"];
        $tableau[] = $_GET["nomAdherent"];
        $tableau[] = $_GET["prenomAdherent"];
        $tableau[] = $_GET["email"];
        $tableau[] = $_GET["numCategorie"];

        $result = Client::updateAdherent($tableau[0], $tableau[1], $tableau[2], $tableau[3], $tableau[4], $tableau[5]);

        if ($result) {
            self::lireObjets();
        } else {
            self::afficherFormulaireModificationObjet();
        }
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
        $result = Client::checkMDP($login, $password);
        $adherent = Client::getObjetById($login);
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
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time() - 1);
        self::afficherFormulaireConnexion();
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
        mail($destinataire, $sujet, $message, implode("\r\n", $entete));

        Client::addAdherent($login, $password, $nom, $prenom, $email, 1, $ch);

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
