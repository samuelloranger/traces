<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Modeles\Livre;

class ControleurLivre
{
    private $blade = null;

    public function __construct()
    {
        $this->blade = App::getInstance() -> getBlade();
    }

    /**
     * Fonction index qui call la view
     */
    public function index(): void
    {
        ini_get("upload_max_filesize");

        $tDonnees = array_merge($this -> getDonnees(), ControleurSite::getDonneeFragmentPiedDePage());;
        echo $this->blade->run("livres.index", $tDonnees);
    }

    /**
     * @return array
     */
    public function getDonnees():array{
        /**
         * Définition du nombre de pages
         */
        $nbrLivres = Livre::compter();
        $livresParPage = 5;
        $nombreTotalPages = ceil($nbrLivres/$livresParPage);

        /**
         * Définition de la page courante
         */
        if(isset($_GET["page"])){
            $numeroPage = $_GET["page"];
        }
        else{
            $numeroPage = 1;
        }

        /**
         * Définition du url présent
         */
        $stringURl = $_SERVER['REQUEST_URI'];
        $urlModif = str_replace("&page=" . $numeroPage, "", $stringURl);

        /**
         * Définition du array de données à envoyer dans la page
         */
        $arrLivres = Livre::trouverParLimite(intval($numeroPage) -1 , $livresParPage);

        /**
         * Définition de l'array retourné avec toutes les données
         */
        $arrDonnees = array_merge(
            array("arrLivres" => $arrLivres),
            array("nombreTotalPages" => $nombreTotalPages),
            array("numeroPage" => $numeroPage),
            array("urlPagination" => $urlModif)
        );

        return $arrDonnees;
    }
}

?>
