<?php

declare(strict_types=1);

namespace App;

use App\Controleurs\ControleurCompte;
use App\Controleurs\ControleurLivre;
use App\Controleurs\ControleurPanier;
use App\Controleurs\ControleurSite;
use App\Controleurs\ControleurTransaction;
use App\Session\Session;
use App\Session\SessionPanier;
use \PDO;
use eftec\bladeone\BladeOne;

class App
{
    private static $instance = null;
    private $pdo = null;
    private $blade = null;
    private $cookie = null;
    private $session = null;
    private $panier = null;
    private $filAriane = null;
    private $monControleur = null;

    private function __construct()
    {
    }

    public static function getInstance(): App
    {
        if (App::$instance === null) {
            App::$instance = new App();
        }
        return App::$instance;
    }

    public function demarrer(): void
    {
        $this->getSession()->demarrer();
        $this->configurerEnvironnement();
        $this->routerLaRequete();
    }

    private function configurerEnvironnement(): void
    {
        if ($this->getServeur() === 'serveur-local') {
            error_reporting(E_ALL | E_STRICT);
            ini_set("display_errors", "On");
        } else {
            ini_set("display_errors", "Off");
        }

        date_default_timezone_set('America/Montreal');
        setlocale(LC_TIME, "fr_CA");
        setlocale(LC_ALL, "fr_CA");
        setlocale(LC_MONETARY, "fr_CA.UTF-8");
    }

    public function getPDO(): PDO
    {
        // C'est plus performant en ram de récupérer toujours la même connexion PDO dans toute l'application.
        if ($this->pdo === null) {
            if ($this->getServeur() === 'serveur-local') {
                $maConnexionBD = new ConnexionBD('localhost', 'traces', 'traces_mdp', 'traces');
            } else if ($this->getServeur() === 'serveur-production') {
                $maConnexionBD = new ConnexionBD('localhost', '19_saladsquad', 'lionvert', '19_rpni3_saladsquad');
            }
            $this->pdo = $maConnexionBD->getNouvelleConnexionPDO();
        }
        return $this->pdo;
    }


    public function getBlade(): BladeOne
    {
        if ($this->blade === null) {
            $cheminDossierVues = '../ressources/vues';
            $cheminDossierCache = '../ressources/cache';
            $this->blade = new BladeOne($cheminDossierVues, $cheminDossierCache, BladeOne::MODE_AUTO);
        }
        return $this->blade;
    }

    public function getCookie()
    {
        if ($this->cookie == null) {
            $this->cookie = new Cookie();
        }
        return $this->cookie;
    }

    public function getPanier()
    {
        if ($this->panier == null) {
            $this->panier = new SessionPanier();
        }
        return $this->panier;
    }

    public function getSession()
    {
        if ($this->session == null) {
            $this->session = new Session();
        }
        return $this->session;
    }

    public function getFilAriane(): FilAriane
    {
        if ($this->filAriane === null) {
            $this->filAriane = new FilAriane();
        }
        return $this->filAriane;
    }

    public function getServeur(): string
    {
        // Vérifier la nature du serveur (local VS production)
        $env = 'null';
        if ((substr($_SERVER['HTTP_HOST'], 0, 9) == 'localhost') ||
            (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168') ||
            (substr($_SERVER['SERVER_ADDR'], 0, 7) == '192.168')) {
            $env = 'serveur-local';
        } else {
            $env = 'serveur-production';
        }
        return $env;
    }


    public function routerLaRequete(): void
    {
        $controleur = null;
        $action = null;

        // Déterminer le controleur responsable de traiter la requête
        if (isset($_GET['controleur'])) {
            $controleur = $_GET['controleur'];
        } else {
            $controleur = 'site';
        }

        // Déterminer l'action du controleur
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = 'accueil';
        }

        // Instantier le bon controleur selon la page demandée
        if ($controleur === 'site') {
            $this->monControleur = new ControleurSite();
            switch ($action) {
                case 'accueil':
                    $this->monControleur->accueil();
                    break;
                case 'apropos':
                    $this->monControleur->aPropos();
                    break;
                default:
                    echo 'Erreur 404';
            }
        } else if ($controleur === 'livre') {
            $this->monControleur = new ControleurLivre();
            switch ($action) {
                case "catalogue":
                    $this->monControleur->catalogue();
                    break;
                case "fiche":
                    $this->monControleur->fiche();
                    break;
                case "fenetreModale":
                    $this->monControleur->fenetreModale();
                    break;
                default:
                    echo 'Erreur 404';
            }
        } else if ($controleur === "panier") {
            $this->monControleur = new ControleurPanier();
            switch ($action) {
                case "supprimerItem":
                    $this->monControleur->supprimerItem();
                    break;
                case "updateItem":
                    $this->monControleur->updateItem();
                    break;
                case "panier":
                    $this->monControleur->panier();
                    break;
                case "ajoutPanier":
                    $this->monControleur->ajoutPanier();
                    break;
                case "nbrItemsPanier":
                    $this->monControleur->retournerNbrItemsPanier();
            }
        } else if ($controleur === "transaction") {
            $this->monControleur = new ControleurTransaction();
            switch ($action) {
                case "livraison":
                    $this->monControleur->transaction();
                    break;
                case "facturation":
                    $this->monControleur->facturation();
                    break;
                case "validation":
                    $this->monControleur->validation();
                    break;
                case "confirmation":
                    $this->monControleur->confirmation();
            }
        } else
            if ($controleur === "compte") {
                $this->monControleur = new ControleurCompte();
                switch ($action) {
                    case "connexion":
                        $this->monControleur->connexion();
                        break;
                    case "inscription":
                        $this->monControleur->inscription();
                        break;
                    case "inscrire":
                        $this->monControleur->inscrire();
                        break;
                    case "connecter":
                        $this->monControleur->connecter();
                        break;
                }
            } else {
                echo 'Erreur 404';
            }
    }

}


