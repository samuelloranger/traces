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
use mysql_xdevapi\Exception;

class ControleurCompte {
    private $blade = null;
    private $session = null;
    private $panier = null;

    public function __construct() {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
        $this->panier = App::getInstance()->getPanier();
    }

    public function connexion(): void {
        $tDonnees = array_merge([], ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("compte.connexion", $tDonnees);
    }

    public function inscription(): void {
        $nbrItemsPanier = $this->panier -> getNombreTotalItemsDifferents();

        $panierVide = true;
        if($nbrItemsPanier){
            $panierVide = false;
        }

        $tDonnees = array_merge(
            ControleurSite::getDonneeFragmentPiedDePage(),
            ["nbrItemsPanier" => $nbrItemsPanier],
            ["panierVide" => $panierVide]
        );
        echo $this->blade->run("compte.inscription", $tDonnees);
    }

    public function inscrire() {
        $formulaireValide = $this->validerInscription();

        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $courriel = $_POST["email"];
        $mdp = $_POST["mdp"];

        if ($formulaireValide) {
            try {
                User::insererUser($prenom, $nom, $courriel, $mdp);
                echo "Compte cree";
            } catch (\Exception $e) {
                echo "<br> Erreur de requete <br>";
                echo $e;
            }
        }

        $this->session->setItem("courriel", $courriel);
        $this->session->setItem("estConnecte", true);

        header("Location: index.php?controleur=accueil&action=accueil");
    }

    public function connecter() {
        $formulaireValide = $this->validerConnexion();
    }

    public function validerInscription() {
        return true;
    }

    public function validerConnexion() {
        return true;
    }
}