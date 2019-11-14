<?php

declare(strict_types=1);

namespace App\Controleurs;

use App\App;
use App\Modeles\Adresse;


class ControleurLivraison
{
    private $blade = null;
    private $session = null;

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
        $this->session = App::getInstance()->getSession();
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
                array("codePostal" => $this->tDonneesSaisies['codePostal']),
                array("tValidation" => $this->session->getItem("tValidation"))
            );
        } else {
            $tDonnees = array_merge(
                ControleurSite::getDonneeFragmentPiedDePage(),
                array("nomPage" => "Livraison"),
                array("nom" => ""),
                array("prenom" => ""),
                array("adresse" => ""),
                array("ville" => ""),
                array("codePostal" => ""),
                array("tValidation" => $this->session->getItem("tValidation"))
            );
        }
        echo $this->blade->run("transaction.livraison", $tDonnees);
    }

    public function insererAdresseSession()
    {
        $tValidation = $this->validerAdresse();
        $formulaireValide = $tValidation['formulaireValide'];

        if ($formulaireValide === true) {
            $this->tDonneesSaisies = "";
            $_SESSION['livraison'] = $_POST;
            header("Location: index.php?controleur=facturation&action=facturation");
        } else {
            $this->tDonneesSaisies = $_POST;
            $this->session->setItem("tValidation", $tValidation);
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

    public function validerAdresse(): array
    {
        $fichierJSON = file_get_contents('../ressources/liaisons/typescript/messagesLivraison.json');
        $tMessages = json_decode($fichierJSON, true);
        $tValidation = [
            "champs" => [],
            "champsValide" => [],
            "formulaireValide" => false
        ];
        $regex = [
            "prenom" => "#[a-zA-Z]{3,30}$#",
            "nom" => "#[a-zA-Z]{3,30}$#",
            "adresse" => "#^\s*\S+(?:\s+\S+){2}#",
            "ville" => "#^[a-zA-ZáàâäãåçéèêëíìîïñóòôöõúùûüýÿæœÁÀÂÄÃÅÇÉÈÊËÍÌÎÏÑÓÒÔÖÕÚÙÛÜÝŸÆŒ._\s-]{5,60}$#",
            "codePostal" => "#^[ABCEGHJ-NPRSTVXY][0-9][ABCEGHJ-NPRSTV-Z] [0-9][ABCEGHJ-NPRSTV-Z][0-9]$#"
        ];

        // Nom
        if ($_POST['nom'] !== "") {
            if (preg_match($regex["nom"], $_POST['nom'])) {
                $tValidation['champsValide']['nom'] = true;
            } else {
                $tValidation['champsValide']['nom'] = false;
                $tValidation['champs']['nom']['message'] = $tMessages['nom']['pattern'];
            }
        } else {
            $tValidation['champsValide']['nom'] = false;
            $tValidation['champs']['nom']['message'] = $tMessages['nom']['vide'];
        }

        // Prénom
        if ($_POST['prenom'] !== "") {
            if (preg_match($regex["prenom"], $_POST['prenom'])) {
                $tValidation['champsValide']['prenom'] = true;
            } else {
                $tValidation['champsValide']['prenom'] = false;
                $tValidation['champs']['prenom']['message'] = $tMessages['prenom']['pattern'];
            }
        } else {
            $tValidation['champsValide']['prenom'] = false;
            $tValidation['champs']['prenom']['message'] = $tMessages['prenom']['vide'];
        }

        // Adresse
        if ($_POST['adresse'] !== "") {
            if (preg_match($regex["adresse"], $_POST['adresse'])) {
                $tValidation['champsValide']['adresse'] = true;
            } else {
                $tValidation['champsValide']['adresse'] = false;
                $tValidation['champs']['adresse']['message'] = $tMessages['adresse']['pattern'];
            }
        } else {
            $tValidation['champsValide']['adresse'] = false;
            $tValidation['champs']['adresse']['message'] = $tMessages['adresse']['vide'];
        }

        // Ville
        if ($_POST['ville'] !== "") {
            if (preg_match($regex["ville"], $_POST['ville'])) {
                $tValidation['champsValide']['ville'] = true;
            } else {
                $tValidation['champsValide']['ville'] = false;
                $tValidation['champs']['ville']['message'] = $tMessages['ville']['pattern'];
            }
        } else {
            $tValidation['champsValide']['ville'] = false;
            $tValidation['champs']['ville']['message'] = $tMessages['ville']['vide'];
        }

        // Province
        if (isset($_POST['abbrProvince'])) {
            $tValidation['champsValide']['province'] = true;
        } else {
            $tValidation['champsValide']['province'] = false;
        }

        // Code Postal
        if ($_POST['codePostal'] !== "") {
            if (preg_match($regex["codePostal"], $_POST['codePostal'])) {
                $tValidation['champsValide']['codePostal'] = true;
            } else {
                $tValidation['champsValide']['codePostal'] = false;
                $tValidation['champs']['codePostal']['message'] = $tMessages['codePostal']['pattern'];
            }
        } else {
            $tValidation['champsValide']['codePostal'] = false;
            $tValidation['champs']['codePostal']['message'] = $tMessages['codePostal']['vide'];
        }

        if ($tValidation['champsValide']['nom'] === true && $tValidation['champsValide']['prenom'] === true && $tValidation['champsValide']['adresse'] === true && $tValidation['champsValide']['ville'] === true && $tValidation['champsValide']['province'] === true && $tValidation['champsValide']['codePostal'] === true) {
            $tValidation['formulaireValide'] = true;
        }
        return $tValidation;
    }
}