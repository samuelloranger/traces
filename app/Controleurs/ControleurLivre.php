<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Util;
use App\Modeles\Honneur;
use App\Modeles\Categories;
use App\Modeles\Livre;
use App\Modeles\Recension;
use \DateTime;

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

    public function fiche():void{
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
            $livre -> isbn13 = Livre::ISBNToEAN($livre -> isbn);
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
        $isbnLivre = "0";
        if(isset($_GET["isbn"])){
            $isbnLivre = $_GET["isbn"];
        }

        $infosLivre = Livre::trouverParIsbn($isbnLivre);

        $infosLivre -> __set("isbn13", Livre::ISBNToEAN($infosLivre -> __get("isbn")));

        $arrRecensions = Recension::trouverRecensions($infosLivre -> __get("id"));
        foreach($arrRecensions as $rescension){
            $rescension -> description = Util::couperParagraphe($rescension -> description);
            $rescension -> date = new DateTime($rescension -> date);
            $rescension -> date -> format("d M Y");
        }

        //Honneurs
        $arrHonneurs = Honneur::trouverHonneursLivre($infosLivre -> __get("id"));
        foreach($arrHonneurs as $honneur){
            $honneur -> description = Util::couperParagraphe($honneur -> description);
        }
        $arrInfos = array_merge(array("livre" => $infosLivre),
                                array("arrRecensions" => $arrRecensions),
                                array("arrHonneurs" => $arrHonneurs));
        return $arrInfos;
    }
}

?>
