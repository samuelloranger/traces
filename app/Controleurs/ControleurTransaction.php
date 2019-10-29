<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;


class ControleurTransaction
{
    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function transaction(): void
    {
        $tDonnees = array("nomPage"=>"Livraison");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("transaction.livraison",$tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }

    public function facturation():void
    {
        $tDonnees = array("nomPage"=>"Facturation");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("transaction.facturation",$tDonnees); // /ressource/vues/accueil.blade.php doit exister...
    }
}