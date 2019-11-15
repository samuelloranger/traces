<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Adresse;
use App\Modeles\Validation;
use App\Util;


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
        $controleurPanier = new ControleurPanier();
        $arrInfosPanier = $controleurPanier->panier(false, true);
        $tDonnees = array_merge(
            ControleurSite::getDonneeFragmentPiedDePage(),
            array("nomPage" => "Validation"),
            array("adresse" => $arrInfosLivraison["adresse"]),
            array("ville" => $arrInfosLivraison["ville"]),
            array("province" => Adresse::trouverProvince($arrInfosLivraison["abbrProvince"])),
            array("codePostal" => $arrInfosLivraison["codePostal"]),
            array("nomComplet" => $arrInfosFacturation["nomComplet"]),
            array("noCarte" => substr($arrInfosFacturation["noCarte"], -4)),
            array("dateExpiration" => ($arrInfosFacturation["dateExpirationCarte"])),
            array("methodePaiement" => $arrInfosFacturation["methodePaiement"]),
            array("courriel" => $this->session->getItem("courriel")),
            array("elementsPanier" => $arrInfosPanier["elementsPanier"]),
            array("fraisLivraison" => $arrInfosPanier["fraisLivraison"]),
            array("montantTPS" => $arrInfosPanier["montantTPS"]),
            array("montantSousTotal" => $arrInfosPanier["montantSousTotal"]),
            array("dateLivraisonEstimee" => $arrInfosPanier["dateLivraisonEstimee"]),
            array("modeLivraison" => $arrInfosPanier["modeLivraison"]),
            array("montantTotal" => $arrInfosPanier["montantTotal"]),
            Util::getInfosHeader()
        );
        echo $this->blade->run("transaction.validation", $tDonnees);
    }

    public function confirmation(): void
    {
        $arrInfosLivraison = $this->session->getItem("livraison");
        $arrInfosFacturation = $this->session->getItem("facturation");
        $controleurPanier = new ControleurPanier();
        $arrInfosPanier = $controleurPanier->panier(false, true);
        self::insererAdresseBD();
        self::insererMethodePaiementBD();
        $tDonnees = array_merge(
            ControleurSite::getDonneeFragmentPiedDePage(),
            array("nomPage" => "Confirmation"),
            array("adresse" => $arrInfosLivraison["adresse"]),
            array("ville" => $arrInfosLivraison["ville"]),
            array("province" => Adresse::trouverProvince($arrInfosLivraison["abbrProvince"])),
            array("codePostal" => $arrInfosLivraison["codePostal"]),
            array("nomComplet" => $arrInfosFacturation["nomComplet"]),
            array("noCarte" => substr($arrInfosFacturation["noCarte"], -4)),
            array("dateExpiration" => ($arrInfosFacturation["dateExpirationCarte"])),
            array("methodePaiement" => $arrInfosFacturation["methodePaiement"]),
            array("courriel" => $this->session->getItem("courriel")),
            array("elementsPanier" => $arrInfosPanier["elementsPanier"]),
            array("fraisLivraison" => $arrInfosPanier["fraisLivraison"]),
            array("montantTPS" => $arrInfosPanier["montantTPS"]),
            array("montantSousTotal" => $arrInfosPanier["montantSousTotal"]),
            array("dateLivraisonEstimee" => $arrInfosPanier["dateLivraisonEstimee"]),
            array("modeLivraison" => $arrInfosPanier["modeLivraison"]),
            array("montantTotal" => $arrInfosPanier["montantTotal"]),
            Util::getInfosHeader()
        );
        echo $this->blade->run("transaction.confirmation", $tDonnees);
        App::getInstance()->envoyerCourriel($this->session->getItem("courriel"), $tDonnees);
        //App::getInstance()->envoyerCourriel("olivier.12.papineau@gmail.com");

    }

    public function insererAdresseBD(): void
    {
        $prenom = $this->session->getItem("livraison")["prenom"];
        $nom = $this->session->getItem("livraison")["nom"];
        $adresse = $this->session->getItem("livraison")["adresse"];
        $ville = $this->session->getItem("livraison")["ville"];
        $codePostal = $this->session->getItem("livraison")["codePostal"];
        $estDefaut = 0;
        if (isset($this->session->getItem("livraison")["estDefaut"])) {
            $estDefaut = 1;
        }
        $typeAdresse = "livraison";
        $abbrProvince = $this->session->getItem("livraison")["abbrProvince"];
        $courriel = strval($this->session->getItem("courriel"));
        $idClient = intval(Adresse::trouverIdClient($courriel));

        Validation::insererAdresse($prenom, $nom, $adresse, $ville, $codePostal, $estDefaut, $typeAdresse, $abbrProvince, $idClient);
        // Si le checkbox est coché change seulement le type d'adresse pour "facturation"
        if (isset($this->session->getItem('livraison')['adresseFacturation'])) {
            $typeAdresse = "facturation";
            Validation::insererAdresse($prenom, $nom, $adresse, $ville, $codePostal, $estDefaut, $typeAdresse, $abbrProvince, $idClient);
        }
    }

    public function insererMethodePaiementBD(): void
    {
        $methodePaiement = $this->session->getItem("facturation")["methodePaiement"];
        $estPaypal = 0;
        $typeCarte = "";
        if ($methodePaiement == "Paypal") {
            $estPaypal = 1;
            $typeCarte = "Paypal";
        }
        if ($methodePaiement == "VISA") {
            $typeCarte = "VISA";
        }
        if ($methodePaiement == "Master Card") {
            $typeCarte = "Master Card";
        }
        if ($methodePaiement == "American Express") {
            $typeCarte = "American Express";
        }
        $nomComplet = $this->session->getItem("facturation")["nomComplet"];
        $noCarte = intval($this->session->getItem("facturation")["noCarte"]);
        $code = intval($this->session->getItem("facturation")["code"]);
        $dateExpirationCarte = $this->session->getItem("facturation")["dateExpirationCarte"];
        $estDefaut = 0;
        if (isset($this->session->getItem("facturation")["estDefaut"])) {
            $estDefaut = 1;
        }
        $courriel = strval($this->session->getItem("courriel"));
        $idClient = intval(Adresse::trouverIdClient($courriel));

        Validation::insererMethodePaiement($estPaypal, $nomComplet, $noCarte, $typeCarte, $dateExpirationCarte, $code, $estDefaut, $idClient);
    }

}