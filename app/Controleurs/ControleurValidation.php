<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;


class ControleurValidation
{
    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function validation(): void
    {
        $tDonnees = array("nomPage" => "Validation");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("transaction.validation", $tDonnees);
    }

    public function confirmation(): void
    {
        $tDonnees = array("nomPage" => "Confirmation");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("transaction.confirmation", $tDonnees);
    }
}