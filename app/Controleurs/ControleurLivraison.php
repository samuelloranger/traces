<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Adresse;


class ControleurLivraison
{
    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function livraison(): void
    {
        // $arrAdresse = Adresse::trouverTout();
        if (isset($this->tDonneesSaisies)) {
            $tDonnees = array_merge(
                ControleurSite::getDonneeFragmentPiedDePage(),
                array("nomPage" => "Livraison"),
                array("nom" => $this->tDonneesSaisies['nom']),
                array("prenom" => $this->tDonneesSaisies['prenom']),
                array("adresse" => $this->tDonneesSaisies['adresse']),
                array("ville" => $this->tDonneesSaisies['ville']),
                array("codePostal" => $this->tDonneesSaisies['codePostal'])
            );
        } else {
            $tDonnees = array_merge(
                ControleurSite::getDonneeFragmentPiedDePage(),
                array("nomPage" => "Livraison"),
                array("nom" => ""),
                array("prenom" => ""),
                array("adresse" => ""),
                array("ville" => ""),
                array("codePostal" => "")
            );
        }
        echo $this->blade->run("transaction.livraison", $tDonnees);
    }

    public function insererAdresseSession()
    {
        $validerAdresse = $this->validerAdresse();

        if ($validerAdresse === true) {
            $this->tDonneesSaisies = "";
            $_SESSION['livraison'] = $_POST;
            header("Location: index.php?controleur=facturation&action=facturation");
        } else {
            $this->tDonneesSaisies = $_POST;
            $this->livraison();
        }
    }

//    public function insererAdresseBD()
//    {
//
//        $prenom = $_POST["prenom"];
//        $nom = $_POST["nom"];
//        $adresse = $_POST["adresse"];
//        $ville = $_POST["ville"];
//        $codePostal = $_POST["codePostal"];
//        if (isset($_POST["estDefaut"])) {
//            $estDefaut = 1;
//        }
//        $typeAdresse = "livraison";
//        $abbrProvince = $_POST['abbrProvince'];
//        $idClient = Adresse::trouverIdClient($_SESSION['courriel']);
//
//        Adresse::insererAdresse($prenom, $nom, $adresse, $ville, $codePostal, $estDefaut, $typeAdresse, $abbrProvince, $idClient);
//        // Si le checkbox est coché change seulement le type d'adresse pour "facturation"
//        if (isset($_POST['adresseFacturation'])) {
//            var_dump("HELLOOO!");
//            $typeAdresse = "facturation";
//        }
//    }

    public function validerAdresse(): bool
    {
        $regex = [
            "prenom" => "#[a-zA-Z]{3,30}$#",
            "nom" => "#[a-zA-Z]{3,30}$#",
            "adresse" => "#^\s*\S+(?:\s+\S+){2}#",
            "ville" => "#^([a-zA-Z\u0080-\u024F]+(?:. |-| |'))*[a-zA-Z\u0080-\u024F]*$#",
            "codePostal" => "#^[ABCEGHJ-NPRSTVXY][0-9][ABCEGHJ-NPRSTV-Z] [0-9][ABCEGHJ-NPRSTV-Z][0-9]$#"
        ];

        // Nom
        if ($_POST['nom'] !== "") {
            if (preg_match($regex["nom"], $_POST['nom'])) {
                $nomValide = true;
            } else {
                $nomValide = false;
            }
        } else {
            $nomValide = false;
        }

        // Prénom
        if ($_POST['prenom'] !== "") {
            if (preg_match($regex["prenom"], $_POST['prenom'])) {
                $prenomValide = true;
            } else {
                $prenomValide = false;
            }
        } else {
            $prenomValide = false;
        }

        // Adresse
        if ($_POST['adresse'] !== "") {
            if (preg_match($regex["adresse"], $_POST['adresse'])) {
                $adresseValide = true;
            } else {
                $adresseValide = false;
            }
        } else {
            $adresseValide = false;
        }

        // Ville
        if ($_POST['ville'] !== "") {
            if (preg_match($regex["ville"], $_POST['ville'])) {
                $villeValide = true;
            } else {
                $villeValide = false;
            }
        } else {
            $villeValide = false;
        }

        // Province
        if (isset($_POST['abbrProvince'])) {
            $provinceValide = true;
        } else {
            $provinceValide = false;
        }

        // Code Postal
        if ($_POST['codePostal'] !== "") {
            if (preg_match($regex["codePostal"], $_POST['codePostal'])) {
                $codePostalValide = true;
            } else {
                $codePostalValide = false;
            }
        } else {
            $codePostalValide = false;
        }

        // Par défaut


        // Adresse facturation

        if ($nomValide === true && $prenomValide === true && $adresseValide === true && $villeValide === true && $provinceValide === true && $codePostalValide === true) {
            return true;
        } else {
            return false;
        }

    }
}
