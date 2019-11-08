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
                array("province" => Adresse::trouverProvince($_SESSION['livraison']['abbrProvince'])),
                array("tValidation" => $this->session->getItem("tValidation"))
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
                array("province" => Adresse::trouverProvince($_SESSION['livraison']['abbrProvince'])),
                array("tValidation" => $this->session->getItem("tValidation"))
            );
        }
        echo $this->blade->run("transaction.facturation", $tDonnees);
    }

    public function insererModePaiementSession()
    {
        $tValidation = $this->validerModePaiement();
        $formulaireValide = $tValidation['formulaireValide'];
        if ($formulaireValide === true) {
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
            $this->session->setItem("tValidation", $tValidation);
            $this->facturation();
        }
    }

    public function validerModePaiement(): array
    {
        $fichierJSON = file_get_contents('../ressources/liaisons/typescript/messagesFacturation.json');
        $tMessages = json_decode($fichierJSON, true);
        $tValidation = [
            "champs" => [],
            "champsValide" => [],
            "formulaireValide" => false
        ];
        $regex = [
            "nomComplet" => "#^[A-Z][a-z]*(\s[A-Z][a-z]*)+$#",
            "noCarte" => "#^(?:4[0-9]{12}(?:[0-9]{3})?|(?:5[1-5][0-9]{2}|222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)[0-9]{12}|3[47][0-9]{13})$#",
            "dateExpirationCarte" => "#^(0[1-9]|1[0-2])\/?([0-9]{4}|[0-9]{2})$#",
            "code" => "#^[0-9]{3,4}$#"
        ];

        // Nom complet
        if ($_POST['nomComplet'] !== "") {
            if (preg_match($regex["nomComplet"], $_POST['nomComplet'])) {
                $tValidation['champsValide']['nom'] = true;
            } else {
                $tValidation['champsValide']['nom'] = false;
                $tValidation['champs']['nom']['message'] = $tMessages['nom']['pattern'];
            }
        } else {
            $tValidation['champsValide']['nom'] = false;
            $tValidation['champs']['nom']['message'] = $tMessages['nom']['vide'];
        }

        // Numéro de carte
        if ($_POST['noCarte'] !== "") {
            if (preg_match($regex["noCarte"], $_POST['noCarte'])) {
                $tValidation['champsValide']['numeroCarte'] = true;
            } else {
                $tValidation['champsValide']['numeroCarte'] = false;
                $tValidation['champs']['numeroCarte']['message'] = $tMessages['numeroCarte']['pattern'];
            }
        } else {
            $tValidation['champsValide']['numeroCarte'] = false;
            $tValidation['champs']['numeroCarte']['message'] = $tMessages['numeroCarte']['vide'];
        }

        // Date d'expiration
        if ($_POST['dateExpirationCarte'] !== "") {
            if (preg_match($regex["dateExpirationCarte"], $_POST['dateExpirationCarte'])) {
                $tValidation['champsValide']['dateExpiration'] = true;
            } else {
                $tValidation['champsValide']['dateExpiration'] = false;
                $tValidation['champs']['dateExpiration']['message'] = $tMessages['dateExpiration']['pattern'];
            }
        } else {
            $tValidation['champsValide']['dateExpiration'] = false;
            $tValidation['champs']['dateExpiration']['message'] = $tMessages['dateExpiration']['vide'];
        }
        // Code CVC
        if ($_POST['code'] !== "") {
            if (preg_match($regex["code"], $_POST['code'])) {
                $tValidation['champsValide']['code'] = true;
            } else {
                $tValidation['champsValide']['code'] = false;
                $tValidation['champs']['code']['message'] = $tMessages['code']['pattern'];
            }
        } else {
            $tValidation['champsValide']['code'] = false;
            $tValidation['champs']['code']['message'] = $tMessages['code']['vide'];
        }

        if ($tValidation['champsValide']['nom'] === true && $tValidation['champsValide']['numeroCarte'] === true && $tValidation['champsValide']['dateExpiration'] === true && $tValidation['champsValide']['code'] === true) {
            $tValidation['formulaireValide'] = true;
        }
        return $tValidation;


    }
}