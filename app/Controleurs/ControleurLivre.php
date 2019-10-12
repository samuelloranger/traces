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

    public function __construct()
    {
        $this->blade = App::getInstance()->getBlade();
    }

    public function ajoutPanier(){
        if(isset($_GET["isbn"]) && isset($_GET["qte"])){
            $isbn = $_GET["isbn"];
            $qte = intval($_GET["qte"]);

            $livre = Livre::trouverParIsbn($isbn);
            App::getInstance()->getPanier()->ajouterItem($livre, $qte);
        }

        header("Location: index.php?controleur=livre&action=fiche&isbn=" . $isbn);
    }

    /**
     * Fonction index qui call la view
     */
    public function catalogue(): void
    {
        $tDonnees = array_merge($this->getDonneesLivres(), ControleurSite::getDonneeFragmentPiedDePage());;
        echo $this->blade->run("livres.catalogue", $tDonnees);
    }

    public function fiche(): void
    {
        $tDonnees = array_merge($this->getDonneesUnLivre(), ControleurSite::getDonneeFragmentPiedDePage());;
        echo $this->blade->run("livres.fiche", $tDonnees);
    }

    /**
     * @return array
     */

    public function getDonneesLivres(): array
    {
        /**
         * Définition de la catégorie séléctionnée
         */
        $id_categorie = 0;
        if (isset($_GET["categorie"])) {
            $id_categorie = intval($_GET["categorie"]);
        }


        /**
         * Définition du tri
         */
        $trierPar = "";
        if (isset($_GET["trierPar"])) {
            $trierPar = $_GET["trierPar"];
        }


        /**
         * Définition de la page courante
         */
        if (isset($_GET["page"])) {
            $numeroPage = $_GET["page"];
        } else {
            $numeroPage = 1;
        }


        /**
         * Définition du nombre de pages
         */
        if (isset($_GET["nbParPages"])) {
            if ($_GET["nbParPages"] == '9') {
                $livresParPage = 9;
            }
            if ($_GET["nbParPages"] == '18') {
                $livresParPage = 18;
            }
            if ($_GET["nbParPages"] == '36') {
                $livresParPage = 36;
            }
        } else {
            $livresParPage = 9;
        }


        /**
         * Définition du array de données à envoyer dans la page
         */
        $arrLivres = Livre::trouverParLimite(intval($numeroPage) - 1, $livresParPage, $id_categorie, $trierPar);
        foreach ($arrLivres as $livre) {
            $livre->isbn13 = Util::ISBNToEAN($livre->isbn);
        }

        $nbrLivres = Livre::compter($id_categorie);
        $nombreTotalPages = ceil($nbrLivres / $livresParPage);


        /**
         * Définition du url présent
         */
        $stringURl = $_SERVER['REQUEST_URI'];
        $urlModif = str_replace("&page=" . $numeroPage, "", $stringURl);

        /**
         * Définition du array des catégories
         */
        $arrCategories = Categories::trouverTout();


        /**
         * Définition de l'array retourné avec toutes les données
         */
        $arrDonnees = array_merge(
            array("arrLivres" => $arrLivres),
            array("arrCategories" => $arrCategories),
            array("nombreTotalPages" => $nombreTotalPages),
            array("livresParPage" => $livresParPage),
            array("numeroPage" => $numeroPage),
            array("urlPagination" => $urlModif)
        );

        return $arrDonnees;
    }

    public function getDonneesUnLivre(): array
    {
        $isbnLivre = "0";
        if (isset($_GET["isbn"])) {
            $isbnLivre = $_GET["isbn"];
        }

        $infosLivre = Livre::trouverParIsbn($isbnLivre);

        if ($infosLivre == false) {
            header('Location: 404.php');
        }

        $infosLivre->__set("isbn13", Util::ISBNToEAN($infosLivre->__get("isbn")));

        $arrRecensions = Recension::trouverRecensions($infosLivre->__get("id"));
        foreach ($arrRecensions as $rescension) {
            $rescension->description = Util::couperParagraphe($rescension->description);
            $rescension->date = new DateTime($rescension->date);
            $formatted_time = strftime("%d %B %Y", $rescension->date->getTimestamp());
            $rescension->date = $formatted_time;
        }

        //Honneurs
        $arrHonneurs = Honneur::trouverHonneursLivre($infosLivre->__get("id"));
        foreach ($arrHonneurs as $honneur) {
            $honneur->description = Util::couperParagraphe($honneur->description);
        }
        $arrInfos = array_merge(array("livre" => $infosLivre),
            array("arrRecensions" => $arrRecensions),
            array("arrHonneurs" => $arrHonneurs));
        return $arrInfos;
    }
}

?>
