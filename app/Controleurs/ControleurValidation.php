<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Adresse;


class ControleurValidation
{
    private $blade = null;
    private $session = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
    }

    public function validation(): void
    {
        $arrInfosLivraison = $this->session->getItem("livraison");
        $arrInfosFacturation = $this->session->getItem("facturation");
        $arrPanier = $this->session->getItem("panier");



        $tDonnees = array_merge(
            ControleurSite::getDonneeFragmentPiedDePage(),
            array("nomPage" => "Validation"),
            array("adresse" => $arrInfosLivraison["adresse"]),
            array("ville" => $arrInfosLivraison["ville"]),
            array("province" => Adresse::trouverProvince($arrInfosLivraison["abbrProvince"])),
            array("codePostal" => $arrInfosLivraison["codePostal"]),
            array("nomComplet" => $arrInfosFacturation["nomComplet"]),
            array("noCarte" => substr($arrInfosFacturation["noCarte"],-4)),
            array("dateExpiration" => ($arrInfosFacturation["dateExpirationCarte"])),
            array("courriel"=> $this->session->getItem("courriel"))
        );
        echo $this->blade->run("transaction.validation", $tDonnees);
    }

    public function confirmation(): void
    {
        $tDonnees = array("nomPage" => "Confirmation");
        $tDonnees = array_merge($tDonnees, ControleurSite::getDonneeFragmentPiedDePage());
        echo $this->blade->run("transaction.confirmation", $tDonnees);
    }
}