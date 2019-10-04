<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Livre;
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
        $arrCoupsCoeur = Livre::getCoupsCoeur();
        shuffle($arrCoupsCoeur);

        $tDonnees = array_merge($tDonnees, ["arrCoupsCoeur" => $arrCoupsCoeur]);

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

