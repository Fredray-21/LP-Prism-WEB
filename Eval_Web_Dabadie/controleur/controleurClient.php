<?php
require_once("./modele/Client.php");

class ControleurClient extends ControleurObjet
{
    protected static $objet = "Client";
    protected static $cle = "num_client";
    protected static $tableauChamps = array(
        "num_client" => ["text", "Numéro client"],
        "nom" => ["text", "Nom"],
        "prenom" => ["text", "Prénom"],
        "email" => ["email", "Email"],
        "tel" => ["string", "Numéro Téléphone"],
        "password" => ["password", "Mot de passe"],
    );

    public static function afficherFormulaireCreationClient()
    {
        $titre = "Création d'un Client";

        include("vue/debut.php");
        include("vue/menu.php");
        include("vue/formulaireCreationClient.html");
        include("vue/fin.html");
    }

    public static function creerClient()
    {
        $titre = "Création d'un Client";
        $tableau[] = $_GET["login"];
        $tableau[] = $_GET["mdp"];
        $tableau[] = $_GET["nomAdherent"];
        $tableau[] = $_GET["prenomAdherent"];
        $tableau[] = $_GET["email"];
        $tableau[] = $_GET["numCategorie"];


        $result = Client::addAdherent($tableau[0], $tableau[1], $tableau[2], $tableau[3], $tableau[4], $tableau[5]);

        if ($result) {
            header("Location: index.php?controleur=ControleurAdherent&action=lireObjets");
        } else {
            header("Location: index.php?controleur=ControleurAdherent&action=afficherFormulaireCreationObjet");
        }
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
        include("vue/menu.php");
        include("vue/formulaireModificationObjet.php");
        include("vue/fin.html");
    }

    public static function modifierClient()
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
            header("Location: index.php?controleur=ControleurAdherent&action=lireObjets");
        } else {
            header("Location: index.php?controleur=ControleurAdherent&action=afficherFormulaireModificationObjet&login=" . $tableau[0]);
        }
    }

    public static function afficherPanier()
    {
        $titre = "Panier";
        //$tableau = Client::getPanier($_SESSION["login"]);
        $tableauPanier = Client::getPanier(1);
        foreach ($tableauPanier as $article) {
            $id_panier = $article["id"];
            $code_article = $article["code_article"];
            $article = Article::getObjetById($code_article);

            $lienDelete = "<a class='bouton btn-red' href=\"index.php?controleur=controleurArticle&action=removeInPanier&code_panier=$id_panier\"><i class='bi bi-cart-dash'></i></a>";
            $lienDetails = "<a class='bouton btn-rose' href=\"index.php?controleur=controleurArticle&action=lireObjet&code_article=$code_article\"><i class='bi bi-eye'></i></a>";

            $tableauAffichage[] = "<div class='ligne'><div><b>" . $article->get("libelle") . "</b> " . $article->get("prix") . "€</div><div>$lienDetails $lienDelete</div></div>";

        }

        include("vue/debut.php");
        include("vue/menu.php");
        include("vue/panier.php");
        include("vue/fin.html");
    }

    public static function afficherFormulaireConnexion()
    {
        $titre = "Formulaire de connexion/inscription";

        include("vue/debut.php");
        include("vue/formulaireConnexion.html");
        include("vue/fin.html");
    }

    public static function connecterClient()
    {
        $email_client = $_GET["email_client"];
        $password = $_GET["password"];

        $client = Client::getClientByEmail($email_client);
        if ($client) {
            $num_client = $client->get("num_client");
            $result = Client::checkMDP($num_client, $password);

            if ($result) {
                $_SESSION["user"] = $client->get("num_client");
                $_SESSION["isAdmin"] = $client->isAdmin();
                header("Location: index.php");
            }
        } else {
            header("Location: index.php");
        }
    }

    public static function deconnecterClient()
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
}
