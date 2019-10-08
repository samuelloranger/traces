<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Util;
use App\Modeles\Honneur;
use App\Modeles\Categories;
use App\Modeles\Livre;
use App\Modeles\Rescension;
use DateTime;

class ControleurLivre
{
    private $blade = null;

    public function __construct(){
        $this->blade = App::getInstance() -> getBlade();
    }

    /**s
     * Fonction index qui call la view
     */
    public function catalogue(): void{
        $tDonnees = array_merge($this -> getDonneesLivres(), ControleurSite::getDonneeFragmentPiedDePage());;
        echo $this->blade->run("livres.catalogue", $tDonnees);
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
        $livresParPage = 9;
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

        foreach($arrLivres as $livre){
            $livre -> isbn = Livre::ISBNToEAN($livre -> isbn);
        }

        $arrCategories = Categories::trouverTout();
        /**
         * Définition de l'array retourné avec toutes les données
         */
        $arrDonnees = array_merge(
            array("arrLivres" => $arrLivres),
            array("arrCategories" => $arrCategories),
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

        $infosLivre = Livre::trouverParId($idLivre);

        $infosLivre -> __set("isbn", Livre::ISBNToEAN($infosLivre -> __get("isbn")));
        $arrRecensions = Rescension::trouverHonneursLivre($infosLivre -> __get("is"));
        foreach($arrRecensions as $rescension){
            $rescension -> description = Util::couperParagraphe($rescension -> description);
            $rescension -> date = new DateTime($rescension -> date);
            $rescension -> date -> format("");
        }

        //Honneurs
        $arrHonneurs = Honneur::trouverHonneursLivre($infosLivre -> __get("id"));
        foreach($arrRecensions as $rescension){
            $rescension -> description = Util::couperParagraphe($rescension -> description);
        }
        $arrInfos = array_merge(array("livre" => $infosLivre),
                                array("arrRecensions" => $arrRecensions),
                                array("arrHonneurs" => $arrHonneurs));
        return $arrInfos;
    }
}

?>
