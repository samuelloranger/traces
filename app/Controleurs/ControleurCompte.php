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
        $tDonnees = array_merge(Util::getInfosHeader(), ControleurSite::getDonneeFragmentPiedDePage());
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
        $tValidation = $this->session->getItem("tValidation");
        $tDonnees = array_merge(
            ControleurSite::getDonneeFragmentPiedDePage(),
            Util::getInfosHeader(),
            ["tValidation" => $tValidation]
        );
        print_r($tValidation);
        echo $this->blade->run("compte.inscription", $tDonnees);
        $this->session->supprimerItem("tValidation");
    }

    public function inscrire(): void {
        $tValidation = $this->validerInscription();
        $formulaireValide = $tValidation["formulaireValide"];

        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $courriel = $_POST["email"];
        $mdp = $_POST["mdp"];

        if ($formulaireValide) {
            $userExiste = User::trouverParCourriel($courriel);
            if ($userExiste === false || $userExiste === null) {
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
            } else {
                echo '<br>Utilisateur existe deja';
            }
        } else {
            $this->session->setItem("tValidation", $tValidation);
            header("Location: index.php?controleur=compte&action=inscription");
            exit;
        }
    }


    /* FONCTIONS DE VALIDATION */
    /* Faire une fonction universelle plus tard */
    public function validerInscription(): array {
        $formulaireValide = true;
        $fichierJSON = file_get_contents('../ressources/liaisons/typescript/messagesInscription.json');
        $tMessages = json_decode($fichierJSON, true);
        $tValidation = [
            "champs" => [],
            "formulaireValide" => true,
        ];

        $prenom = "";
        if (isset($_POST["prenom"])) {
            $prenom = $_POST["prenom"];
        }
        $nom = "";
        if (isset($_POST["nom"])) {
            $nom = $_POST["nom"];
        }
        $courriel = "";
        if (isset($_POST["email"])) {
            $courriel = $_POST["email"];
        }
        $mdp = "";
        if (isset($_POST["mdp"])) {
            $mdp = $_POST["mdp"];
        }
        $c_mdp = "";
        if (isset($_POST["c_mdp"])) {
            $c_mdp = $_POST["c_mdp"];
        }
        $tel = "";
        if (isset($_POST["tel"])) {
            $tel = $_POST["tel"];
        }

        $regex = [
            "prenom" => "#[a-zA-Z]{3,30}$#",
            "nom" => "#[a-zA-Z]{3,30}$#",
            "courriel" => "#^[a-zA-Z0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,}$#",
            "mdp" => "#(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$#",
            "tel" => "#[0-9]{10}#"
        ];

        if (!preg_match($regex["prenom"], $prenom)) {
            //$formulaireValide = false;
            $tValidation["formulaireValide"] = false;
            $tValidation["champs"]["prenom"]["message"] = $tMessages["prenom"]["pattern"];
            $tValidation["champs"]["prenom"]["valeur"] = $prenom;
            $tValidation["champs"]["prenom"]["estValide"] = false;
        } else {
            $tValidation["champs"]["prenom"]["valeur"] = $prenom;
            $tValidation["champs"]["prenom"]["estValide"] = true;
        }
        if (!preg_match($regex["nom"], $nom)) {
            //$formulaireValide = false;
            $tValidation["formulaireValide"] = false;
            $tValidation["champs"]["nom"]["message"] = $tMessages["nom"]["pattern"];
            $tValidation["champs"]["nom"]["valeur"] = $nom;
            $tValidation["champs"]["nom"]["estValide"] = false;
        } else {
            $tValidation["champs"]["nom"]["valeur"] = $nom;
            $tValidation["champs"]["nom"]["estValide"] = true;
        }
        if (!preg_match($regex["courriel"], $courriel)) {
            //$formulaireValide = false;
            $tValidation["formulaireValide"] = false;
            $tValidation["champs"]["email"]["message"] = $tMessages["email"]["pattern"];
            $tValidation["champs"]["email"]["valeur"] = $courriel;
            $tValidation["champs"]["email"]["estValide"] = false;
        } else {
            $tValidation["champs"]["email"]["valeur"] = $courriel;
            $tValidation["champs"]["email"]["estValide"] = true;
        }
        if (!preg_match($regex["mdp"], $mdp) || $mdp !== $c_mdp) {
            //$formulaireValide = false;
            $tValidation["formulaireValide"] = false;
            $tValidation["champs"]["mdp"]["message"] = $tMessages["mdp"]["pattern"];
            $tValidation["champs"]["mdp"]["valeur"] = $mdp;
            $tValidation["champs"]["mdp"]["estValide"] = false;
            if ($mdp !== $c_mdp || !preg_match($regex["mdp"], $c_mdp)) {
                $tValidation["champs"]["c_mdp"]["message"] = $tMessages["c_mdp"]["missmatch"];
                $tValidation["champs"]["c_mdp"]["valeur"] = $c_mdp;
                $tValidation["champs"]["c_mdp"]["estValide"] = false;
            }
        } else {
            $tValidation["champs"]["mdp"]["valeur"] = $mdp;
            $tValidation["champs"]["mdp"]["estValide"] = true;

            $tValidation["champs"]["c_mdp"]["valeur"] = $c_mdp;
            $tValidation["champs"]["c_mdp"]["estValide"] = true;
        }
        if (!preg_match($regex["tel"], $tel)) {
            $tValidation["formulaireValide"] = false;
            $tValidation["champs"]["tel"]["message"] = $tMessages["tel"]["pattern"];
            $tValidation["champs"]["tel"]["valeur"] = $courriel;
            $tValidation["champs"]["tel"]["estValide"] = false;
        } else {
            $tValidation["champs"]["tel"]["valeur"] = $mdp;
            $tValidation["champs"]["tel"]["estValide"] = true;
        }


        if ($formulaireValide) {
            echo "Formulaire valide";
        } else {
            echo "Invalide";
        }

        return $tValidation;
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