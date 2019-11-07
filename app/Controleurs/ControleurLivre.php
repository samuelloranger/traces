<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Modeles\Commentaires;
use App\Util;
use App\Modeles\Honneur;
use App\Modeles\Categories;
use App\Modeles\Livre;
use App\Modeles\Recension;

class ControleurLivre
{
    private $blade = null;
    private $panier = null;

    public function __construct(){
        $this->blade = App::getInstance()->getBlade();
        $this->panier = App::getInstance()->getPanier();
    }

    /**
     * Fonction index qui call la view
     */
    public function catalogue():void {
        $filAriane = App::getInstance()->getFilAriane();
        $filAriane = $filAriane::majFilAriane();

        /**
         * Définition de la catégorie séléctionnée
         */
        $id_categorie = 0;
        if(isset($_GET["categorie"])){
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
        $numeroPage = 1;
        if (isset($_GET["page"])) {
            $numeroPage = $_GET["page"];
        }

        /**
         * Définition du nombre de pages
         */
        $livresParPage = 9;
        if(isset($_GET["nbParPages"])){
            if ($_GET["nbParPages"] == '9') {
                $livresParPage = 9;
            }
            if ($_GET["nbParPages"] == '18') {
                $livresParPage = 18;
            }
            if ($_GET["nbParPages"] == '36') {
                $livresParPage = 36;
            }
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

        $nbResultats = Livre::compter(0);

        if(isset($_GET['categorie'])){
            $nbResultats = Livre::compter(intval($_GET['categorie']));
        }

        /**
         * Définition de l'array des données
         */
        $tDonnees = array_merge(
                Util::getInfosHeader(),
                array("nbResultats" => $nbResultats),
                array("arrLivres" => $arrLivres),
                array("arrCategories" => $arrCategories),
                array("id_categorie" => $id_categorie),
                array("trierPar" => $trierPar),
                array("nombreTotalPages" => $nombreTotalPages),
                array("livresParPage" => $livresParPage),
                array("numeroPage" => $numeroPage),
                array("filAriane" => $filAriane),
                array("urlPagination" => $urlModif)
        );

        echo $this->blade->run("livres.catalogue", $tDonnees);
    }

    public function fiche():void {
        $isbnLivre = "0";
        if (isset($_GET["isbn"])) {
            $isbnLivre = $_GET["isbn"];
        }

        $infosLivre = Livre::trouverParIsbn($isbnLivre);
        if ($infosLivre == false) {
            header('Location: 404.php');
        }

        $filAriane = App::getInstance()->getFilAriane();
        $filAriane = $filAriane::majFilAriane();

        //Infos du livre
        $infosLivre->__set("isbn13", Util::ISBNToEAN($infosLivre->__get("isbn")));
        $infosLivre->__set("description", Util::couperParagraphe($infosLivre->__get("description")));

        //Recensions
        $arrRecensions = Recension::trouverRecensionsLivre($infosLivre->__get("id"));
        foreach ($arrRecensions as $rescension) {
            $rescension->description = "« " . Util::couperParagraphe($rescension->description) . " »";
            $rescension->date = strftime("%d %B %Y", strtotime($rescension->date));
            $infosLivre->__set("isbn13", Util::ISBNToEAN($infosLivre->__get("isbn")));
        }

        //Honneurs
        $arrHonneurs = Honneur::trouverHonneursLivre($infosLivre->__get("id"));
        foreach ($arrHonneurs as $honneur) {
            $honneur->description = Util::couperParagraphe($honneur->description, 100);
        }

        //Commentaires
        $arrCommentaires = Commentaires::trouverParISBN($infosLivre->__get("isbn"));


        $arrInfos = array_merge(
            Util::getInfosHeader(),
            array("livre" => $infosLivre),
            array("arrRecensions" => $arrRecensions),
            array("arrHonneurs" => $arrHonneurs),
            array("arrCommentaires" => $arrCommentaires),
            array("filAriane" => $filAriane)
        );

        $tDonnees = array_merge($arrInfos, ControleurSite::getDonneeFragmentPiedDePage());;
        echo $this->blade->run("livres.fiche", $tDonnees);
    }

    public function fenetreModale():void{
        $isbn = "";
        if(isset($_POST["isbn"])){
            $isbn = $_POST["isbn"];
        }

        $livre = Livre::trouverParIsbn($isbn);
        $arrInfos = array(
            "titre" => $livre->__get("titre"),
            "url" => $livre->getImageUrl("carre"),
            "prix" => $livre->__get("prix"),
            "sous-total" => $this->panier->getMontantTotal()
        );

        echo json_encode($arrInfos);
    }
}

?>
