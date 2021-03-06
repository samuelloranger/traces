<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\ConnexionBD;
use App\Modeles\Actualite;
use App\Modeles\Livre;
use App\Session\SessionPanier;
use App\Util;
use \DateTime;
use PDO;

class ControleurSite
{

    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function accueil(): void
    {
        $tDonnees = array("nomPage" => "Accueil");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());

        $arrNouveautes = Livre::getNouveautes();
        foreach ($arrNouveautes as $livre) {
            $livre->isbn13 = Util::ISBNToEAN($livre->isbn);
        }
        shuffle($arrNouveautes);

        $arrCoupsCoeur = Livre::getCoupsCoeur();
        foreach ($arrCoupsCoeur as $livre) {
            $livre->isbn13 = Util::ISBNToEAN($livre->isbn);
        }
        shuffle($arrCoupsCoeur);

        $arrActualites = Actualite::trouverTout();
        shuffle($arrActualites);
        //print_r($arrActualites);

        /**
         * Données du panier
         */
        $panier = App::getInstance()->getPanier();
        $nbrItemsPanier = $panier->getNombreTotalItemsDifferents();

        $panierVide = true;
        if ($nbrItemsPanier) {
            $panierVide = false;
        }

        $tDonnees = array_merge($tDonnees, ["arrNouveautes" => $arrNouveautes]);
        $tDonnees = array_merge($tDonnees, ["arrCoupsCoeur" => $arrCoupsCoeur]);
        $tDonnees = array_merge($tDonnees, ["arrActualites" => $arrActualites]);
        $tDonnees = array_merge($tDonnees, ["panierVide" => $panierVide]);
        $tDonnees = array_merge($tDonnees, Util::getInfosHeader());

        echo $this->blade->run("accueil", $tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }

    public function apropos(): void
    {
        $tDonnees = array("nomPage" => "À propos");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("apropos", $tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }

    public static function getDonneeFragmentPiedDePage()
    {
        $date = new DateTime();
        return array("dateDuJour" => $date->format('d M Y'));
    }

    public function recherche()
    {
        $livreRecherche = "";
        if (isset($_POST['recherche'])) {
            $livreRecherche = $_POST['recherche'];
        }

        $arrRecherche = array();
        if($livreRecherche !== ""){
            $arrRecherche = Livre::rechercherParTitre($livreRecherche);
        }

        forEach($arrRecherche as $resultat){
            $resultat->titre = Util::corrigerTitre($resultat->titre);
        }

        // Echo
//
//        var_dump($arrRecherche);
        $tDonnees = array("arrRecherche" => $arrRecherche);
        echo $this->blade->run("fragments.recherche", $tDonnees);
    }
}

