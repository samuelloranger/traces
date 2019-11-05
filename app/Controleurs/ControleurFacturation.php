<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;


class ControleurFacturation
{
    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function facturation(): void
    {
        $tDonnees = array("nomPage" => "Facturation");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("transaction.facturation", $tDonnees);
    }

}