<?php

declare(strict_types=1);

namespace App;

use App\Controleurs\ControleurLivre;
use App\Controleurs\ControleurSite;
use \PDO;
use eftec\bladeone\BladeOne;

class App
{
    private static $instance = null;
    private $pdo = null;
    private $blade = null;

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

    public function demarrer():void
    {
        $this->configurerEnvironnement();
        $this->routerLaRequete();
    }

    private function configurerEnvironnement():void
    {
        if($this->getServeur() === 'serveur-local'){
            error_reporting(E_ALL | E_STRICT);
        }
        date_default_timezone_set('America/Montreal');

    }

    public function getPDO():PDO
    {
        // C'est plus performant en ram de récupérer toujours la même connexion PDO dans toute l'application.
        if($this->pdo === null)
        {
            if($this->getServeur() === 'serveur-local')
            {
                $maConnexionBD = new ConnexionBD('localhost','traces','traces_mdp','traces');
            }else if($this -> getServeur() === 'serveur-production'){
                $maConnexionBD = new ConnexionBD('timunix2.cegep-ste-foy.qc.ca','19_saladsquad','lionvert','19_rpni3_saladsquad');
            }
            $this -> pdo = $maConnexionBD -> getNouvelleConnexionPDO();
        }
        return $this->pdo;
    }


    public function getBlade():BladeOne
    {
        if($this->blade === null){
            $cheminDossierVues = '../ressources/vues';
            $cheminDossierCache = '../ressources/cache';
            $this->blade = new BladeOne($cheminDossierVues,$cheminDossierCache,BladeOne::MODE_AUTO);
        }
        return $this->blade;
    }


    public function getServeur(): string
    {
        // Vérifier la nature du serveur (local VS production)
        $env = 'null';
        if ((substr($_SERVER['HTTP_HOST'], 0, 9) == 'localhost') ||
            (substr($_SERVER['HTTP_HOST'], 0, 7) == '192.168')  ||
            (substr($_SERVER['SERVER_ADDR'], 0, 7) == '192.168'))
        {
            $env = 'serveur-local';
        } else {
            $env = 'serveur-production';
        }
        return $env;
    }


    public function routerLaRequete():void
    {
        $controleur = null;
        $action = null;

        // Déterminer le controleur responsable de traiter la requête
        if (isset($_GET['controleur'])){
            $controleur = $_GET['controleur'];
        }else{
            $controleur = 'site';
        }

        // Déterminer l'action du controleur
        if (isset($_GET['action'])){
            $action = $_GET['action'];
        }else{
            $action = 'accueil';
        }

        // Instantier le bon controleur selon la page demandée
        if ($controleur === 'site'){
            $this -> monControleur = new ControleurSite();
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
        }
        else if($controleur === 'livre'){
            $this -> monControleur = new ControleurLivre();
            switch ($action) {
                case "index":
                    $this -> monControleur -> index();
                    break;
                case "fiche":
                    $this -> monControleur -> livre();
                    break;
                default:
                    echo 'Erreur 404';
            }
        }
        else{
            echo 'Erreur 404';
        }
    }

}