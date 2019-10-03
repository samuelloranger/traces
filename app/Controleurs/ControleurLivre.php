<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Modeles\Livre;

class ControleurLivre
{
    private $blade = null;

    public function __construct(){
        $this->blade = App::getInstance() -> getBlade();
    }

    /**
     * Fonction index qui call la view
     */
    public function index(): void{
        $tDonnees = array_merge($this -> getDonneesLivres(), ControleurSite::getDonneeFragmentPiedDePage());;
        echo $this->blade->run("livres.index", $tDonnees);
    }

    public function livre():void{
        $tDonnees = array_merge($this -> getDonneesUnLivre(), ControleurSite::getDonneeFragmentPiedDePage());;
        echo $this->blade->run("livres.fiche", $tDonnees);
    }

    /**
     * @return array
     */
    public function getDonneesLivres():array{
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

    public function getDonneesUnLivre():array{
        $idLivre = 0;
        if(isset($_GET["idLivre"])){
            $idLivre = (int)$_GET["idLivre"];
        }

        $infosLivre = array("livre" => Livre::trouverParId($idLivre));

        return $infosLivre;
    }
}

?>
