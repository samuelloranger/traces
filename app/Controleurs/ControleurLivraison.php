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
        $tDonnees = array_merge(
            ControleurSite::getDonneeFragmentPiedDePage(),
            array("nomPage" => "Livraison")
        );
        echo $this->blade->run("transaction.livraison", $tDonnees);
    }

    public function insererAdresse()
    {
        $prenom = $_POST["prenom"];
        $nom = $_POST["nom"];
        $adresse = $_POST["adresse"];
        $ville = $_POST["ville"];
        $codePostal = $_POST["codePostal"];
        if (isset($_POST["estDefaut"])) {
            $estDefaut = 1;
        }
        $typeAdresse = "livraison";
        $abbrProvince = $_POST['abbrProvince'];
        //$idClient = $_SESSION['id_client'];

        Adresse::insererAdresse($prenom, $nom, $adresse, $ville, $codePostal, $estDefaut, $typeAdresse, $abbrProvince, $idClient);
        // Si le checkbox est coché change seulement le type d'adresse pour "facturation"
        if (isset($_POST['adresseFacturation'])) {
            var_dump("HELLOOO!");
        }

        echo "Adresse ajoutée";

        //header("Location: index.php?controleur=facturation&action=facturation");
    }

}
