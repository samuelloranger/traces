<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Modeles\User;
use App\Modeles\Livre;
use App\Util;
use DateInterval;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Locale;

class ControleurCompte {
    private $blade = null;
    private $session = null;

    public function __construct() {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
    }

    public function connexion(): void {
        $tDonnees = array_merge(Util::getInfosPanier(), ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("compte.connexion", $tDonnees);
    }

    public function connecter() {
        $formulaireValide = $this->validerConnexion();

        $courriel = $_POST["email"];
        $mdp = $_POST["mdp"];
        $user = null;
        $cryptMdp = User::getHash($courriel);

        if ($formulaireValide) {
            //print_r($cryptMdp);
            if (password_verify($mdp, $cryptMdp)) {
                $user = User::trouverParConnexion($courriel, $cryptMdp);
                if ($user !== null) {
                    echo "$mdp <br>";

                    $this->session->setItem("courriel", $user->__get("courriel"));
                    $this->session->setItem("estConnecte", true);

                    header("Location: index.php?controleur=site&action=accueil");
                } else {
                    echo "Connexion echouee";
                }
            }
        }
    }

    public function inscription(): void {
        $tDonnees = array_merge(
            ControleurSite::getDonneeFragmentPiedDePage(),
            Util::getInfosPanier());
        echo $this->blade->run("compte.inscription", $tDonnees);
    }

    public function inscrire(): void {
        $formulaireValide = $this->validerInscription();

        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $courriel = $_POST["email"];
        $mdp = $_POST["mdp"];

        if ($formulaireValide) {
            try {
                User::insererUser($prenom, $nom, $courriel, password_hash($mdp, PASSWORD_DEFAULT));
                echo "Compte cree";
                $this->session->setItem("courriel", $courriel);
                $this->session->setItem("estConnecte", true);

                header("Location: index.php?controleur=site&action=accueil");

            } catch (\Exception $e) {
                echo "<br> Erreur de requete <br>";
                echo $e;
            }
        }
    }


    /* FONCTIONS DE VALIDATION */
    /* Faire une fonction universelle plus tard */
    public function validerInscription(): bool {
        $formulaireValide = true;

        $prenom = null;
        if (isset($_POST["prenom"])) {
            $prenom = $_POST["prenom"];
        }
        $nom = null;
        if (isset($_POST["nom"])) {
            $nom = $_POST["nom"];
        }
        $courriel = null;
        if (isset($_POST["email"])) {
            $courriel = $_POST["email"];
        }
        $mdp = null;
        if (isset($_POST["mdp"])) {
            $mdp = $_POST["mdp"];
        }
        $c_mdp = null;
        if (isset($_POST["c_mdp"])) {
            $c_mdp = $_POST["c_mdp"];
        }

        $regex = [
            "prenom" => "#[a-zA-Z]{3,30}$#",
            "nom" => "#[a-zA-Z]{3,30}$#",
            "courriel" => "#^[a-zA-Z0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,}$#",
            "mdp" => "#(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$#"
        ];

        if (!preg_match($regex["prenom"], $prenom)) $formulaireValide = false;
        if (!preg_match($regex["nom"], $nom)) $formulaireValide = false;
        if (!preg_match($regex["courriel"], $courriel)) $formulaireValide = false;
        if (!preg_match($regex["mdp"], $mdp) || $mdp !== $c_mdp) $formulaireValide = false;

        if ($formulaireValide) {
            echo "Formulaire valide";
        } else {
            echo "Invalide";
        }

        return $formulaireValide;
    }

    public function validerConnexion(): bool {
        $formulaireValide = true;

        $courriel = null;
        if (isset($_POST["email"])) {
            $courriel = $_POST["email"];
        }

        $mdp = null;
        if (isset($_POST["mdp"])) {
            $mdp = $_POST["mdp"];
        }

        $regex = [
            "courriel" => "#^[a-zA-Z0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,}$#",
            "mdp" => "#(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$#"
        ];

        if (!preg_match($regex["courriel"], $courriel)) $formulaireValide = false;
        if (!preg_match($regex["mdp"], $mdp)) $formulaireValide = false;

        if ($formulaireValide) {
            echo "Formulaire valide";
        } else {
            echo "Invalide";
        }

        return $formulaireValide;
    }
}