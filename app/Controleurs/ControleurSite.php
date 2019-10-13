<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Actualite;
use App\Modeles\Livre;
use App\Util;
use \DateTime;

class ControleurSite
{

    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function accueil(): void
    {
        $tDonnees = array("nomPage"=>"Accueil");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());

        $arrNouveautes = Livre::getNouveautes();
        foreach ($arrNouveautes as $livre) {
            $livre -> isbn13 = Util::ISBNToEAN($livre -> isbn);
        }
        shuffle($arrNouveautes);

        $arrCoupsCoeur = Livre::getCoupsCoeur();
        foreach ($arrCoupsCoeur as $livre) {
            $livre -> isbn13 = Util::ISBNToEAN($livre -> isbn);
        }
        shuffle($arrCoupsCoeur);

        $arrActualites = Actualite::trouverTout();
        shuffle($arrActualites);
        //print_r($arrActualites);

        $tDonnees = array_merge($tDonnees, ["arrNouveautes" => $arrNouveautes]);
        $tDonnees = array_merge($tDonnees, ["arrCoupsCoeur" => $arrCoupsCoeur]);
        $tDonnees = array_merge($tDonnees, ["arrActualites" => $arrActualites]);

        echo $this->blade->run("accueil",$tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }

    public function apropos():void
    {
        $tDonnees = array("nomPage"=>"À propos");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("apropos",$tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }


    public static function getDonneeFragmentPiedDePage()
    {
        $date = new DateTime();
        return array("dateDuJour" => $date->format('d M Y'));
    }

}

