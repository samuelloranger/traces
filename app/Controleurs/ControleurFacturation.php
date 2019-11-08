<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Adresse;


class ControleurFacturation
{
    private $blade = null;
    private $session = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
    }

    public function facturation(): void
    {
        if (isset($this->tDonneesSaisies)) {
            $tDonnees = array_merge(ControleurSite::getDonneeFragmentPiedDePage(),
                array("nomPage" => "Facturation"),
                array("nomComplet" => $this->tDonneesSaisies['nomComplet']),
                array("noCarte" => $this->tDonneesSaisies['noCarte']),
                array("dateExpirationCarte" => $this->tDonneesSaisies['dateExpirationCarte']),
                array("code" => $this->tDonneesSaisies['code']),
                array("courriel" => $_SESSION['courriel']),
                array("nom" => $_SESSION['livraison']['nom']),
                array("prenom" => $_SESSION['livraison']['prenom']),
                array("adresse" => $_SESSION['livraison']['adresse']),
                array("ville" => $_SESSION['livraison']['ville']),
                array("codePostal" => $_SESSION['livraison']['codePostal']),
                array("province" => Adresse::trouverProvince($_SESSION['livraison']['abbrProvince']))
            );
        } else {
            $tDonnees = array_merge(ControleurSite::getDonneeFragmentPiedDePage(),
                array("nomPage" => "Facturation"),
                array("nomComplet" => ""),
                array("noCarte" => ""),
                array("dateExpirationCarte" => ""),
                array("code" => ""),
                array("courriel" => $_SESSION['courriel']),
                array("nom" => $_SESSION['livraison']['nom']),
                array("prenom" => $_SESSION['livraison']['prenom']),
                array("adresse" => $_SESSION['livraison']['adresse']),
                array("ville" => $_SESSION['livraison']['ville']),
                array("codePostal" => $_SESSION['livraison']['codePostal']),
                array("province" => Adresse::trouverProvince($_SESSION['livraison']['abbrProvince']))
            );
        }
        echo $this->blade->run("transaction.facturation", $tDonnees);
    }

    public function insererModePaiementSession()
    {
        $validerModePaiement = $this->validerModePaiement();
        if ($validerModePaiement === true) {
            $this->tDonneesSaisies = "";
            $_SESSION['facturation'] = $_POST;
            if ($_SESSION['facturation']['methodePaiement'] === 'VISA' OR $_SESSION['facturation']['methodePaiement'] === 'Master Card' OR $_SESSION['facturation']['methodePaiement'] === 'American Express') {
                $_SESSION['facturation']['typeCarte'] = $_SESSION['facturation']['methodePaiement'];
                $_SESSION['facturation']['estPaypal'] = 0;
            }
            if ($_SESSION['facturation']['methodePaiement'] === 'Paypal') {
                $_SESSION['facturation']['typeCarte'] = null;
                $_SESSION['facturation']['estPaypal'] = 1;
            }
            header("Location: index.php?controleur=validation&action=validation");
        } else {
            $this->tDonneesSaisies = $_POST;
            $this->facturation();
        }
    }

    public function validerModePaiement(): bool
    {
        $regex = [
            "nomComplet" => "#^[A-Z][a-z]*(\s[A-Z][a-z]*)+$#",
            "noCarte" => "#^(?:4[0-9]{12}(?:[0-9]{3})?|(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}|3[47][0-9]{13})$#",
            "dateExpirationCarte" => "#^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$#",
            "code" => "#^[0-9]{3,4}$#"
        ];

        // Nom complet
        if ($_POST['nomComplet'] !== "") {
            if (preg_match($regex["nomComplet"], $_POST['nomComplet'])) {
                $nomCompletValide = true;
            } else {
                $nomCompletValide = false;
            }
        } else {
            $nomCompletValide = false;
        }

        // Numéro de carte
        if ($_POST['noCarte'] !== "") {
            if (preg_match($regex["noCarte"], $_POST['noCarte'])) {
                $noCarteValide = true;
            } else {
                $noCarteValide = false;
            }
        } else {
            $noCarteValide = false;
        }

        // Date d'expiration
        if ($_POST['dateExpirationCarte'] !== "") {
            if (preg_match($regex["dateExpirationCarte"], $_POST['dateExpirationCarte'])) {
                $dateExpirationCarteValide = true;
            } else {
                $dateExpirationCarteValide = false;
            }
        } else {
            $dateExpirationCarteValide = false;
        }
        // Code CVC
        if ($_POST['code'] !== "") {
            if (preg_match($regex["code"], $_POST['code'])) {
                $codeValide = true;
            } else {
                $codeValide = false;
            }
        } else {
            $codeValide = false;
        }

        if ($nomCompletValide === true && $noCarteValide === true && $dateExpirationCarteValide === true && $codeValide === true) {
            return true;
        } else {
            return false;
        }

    }
}