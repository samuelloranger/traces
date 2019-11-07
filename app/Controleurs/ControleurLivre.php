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
    private $session = null;
    private $tMessages = null;

    public function __construct(){
        $this->blade = App::getInstance()->getBlade();
        $this->panier = App::getInstance()->getPanier();
        $this->session = App::getInstance()->getSession();

        $fichierJSON = file_get_contents('../ressources/liaisons/typescript/messagesCommentaires.json');
        $this->tMessages = json_decode($fichierJSON, true);
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

    public function fiche($arrErreursFormCommentaire = array()):void {
        $isbnLivre = "0";
        if (isset($_GET["isbn"])) {
            $isbnLivre = $_GET["isbn"];
        }
        else{
            if(isset($_POST["isbn"])){
                $isbnLivre = $_POST["isbn"];
            }
        }

        $infosLivre = Livre::trouverParIsbn($isbnLivre);
        if ($infosLivre == false) {
            header('Location: index.php');
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

        //Temporaire en attendant la fin du compte
        $this->session->setItem("idClient", 2);
        $idClient = $this->session->getItem("idClient");

        $formCommContientErreur = count($arrErreursFormCommentaire) !== 0;

        $arrInfos = array_merge(
            Util::getInfosHeader(),
            array("livre" => $infosLivre),
            array("arrRecensions" => $arrRecensions),
            array("arrHonneurs" => $arrHonneurs),
            array("arrCommentaires" => $arrCommentaires),
            array("idClient" => $idClient),
            array("filAriane" => $filAriane),
            array("formCommContientErreur" => $formCommContientErreur),
            array("arrErreurs" => $arrErreursFormCommentaire)
        );

        $tDonnees = array_merge($arrInfos, ControleurSite::getDonneeFragmentPiedDePage());;
        echo $this->blade->run("livres.fiche", $tDonnees);
    }

    public function ajouterCommentaire():void{
        $idClientConnecte = $this->session->getItem("idClient");
        $arrErreurs = [];
        $formCommContientErreur = false;

        //Validation commentaire côté serveur
        $idClient = 0;
        if(isset($_POST["idClient"])){
            $idClientEntre = $_POST["idClient"];

            //Validation
            if($idClientEntre == intval($idClientConnecte)){
                $idClient = intval($idClientEntre);
            }
            else{
                if($idClientEntre == ""){
                    $arrErreurs["idClient"] = $this->tMessages["idClient"]["vide"];
                    $formCommContientErreur = true;
                }
                else{
                    $arrErreurs["idClient"] = $this->tMessages["idClient"]["invalide"];
                    $formCommContientErreur = true;
                }
            }
        }

        $isbn = "";
        if(isset($_POST["isbn"])){
            $isbnEntre = $_POST["isbn"];

            if(Util::validerISBN($isbnEntre)){
                $isbn = $isbnEntre;
            }
            else{
                if($isbnEntre == ""){
                    $arrErreurs["isbn"] = $this->tMessages["isbn"]["vide"];
                    $formCommContientErreur = true;
                }
                else{
                    $arrErreurs["isbn"] = $this->tMessages["isbn"]["invalide"];
                    $formCommContientErreur = true;
                }
            }
        }

        $titre_commentaire = "";
        if(isset($_POST["titre_commentaire"])){
            $titre_commentaire = strip_tags($_POST["titre_commentaire"]);

            if(strlen($titre_commentaire) > 50 ){
                $arrErreurs["titre_commentaire"] = $this->tMessages["titre_commentaire"]["longueur"]["long"];
                $formCommContientErreur = true;
            }
            elseif(strlen($titre_commentaire) < 10){
                $arrErreurs["titre_commentaire"] = $this->tMessages["titre_commentaire"]["longueur"]["court"];
                $formCommContientErreur = true;
            }
        }
        else{
            $arrErreurs["titre_commentaire"] = $this->tMessages["titre_commentaire"]["vide"];
            $formCommContientErreur = true;
        }

        $texte_commentaire = "";
        if(isset($_POST["texte_commentaire"])){
            $texte_commentaire = strip_tags($_POST["texte_commentaire"]);

            if(strlen($texte_commentaire) > 255 ){
                $arrErreurs["texte_commentaire"] = $this->tMessages["texte_commentaire"]["longueur"]["long"];
                $formCommContientErreur = true;
            }
            elseif(strlen($texte_commentaire) < 10){
                $arrErreurs["texte_commentaire"] = $this->tMessages["texte_commentaire"]["longueur"]["court"];
                $formCommContientErreur = true;
            }
        }
        else{
            $arrErreurs["texte_commentaire"] = $this->tMessages["texte_commentaire"]["vide"];
            $formCommContientErreur = true;
        }

        $cote = "";
        if(isset($_POST["cote"])){
            $coteEntree = $_POST["cote"];

            if(intval($coteEntree) <= 1 && intval($coteEntree) >= 5){
                $arrErreurs["cote"] = $this->tMessages["cote"]["invalide"];
                $formCommContientErreur = true;
            }
            else{
                $cote = intval($coteEntree);
            }
        }
        else{
            $arrErreurs["cote"] = $this->tMessages["cote"]["vide"];
            $formCommContientErreur = true;
        }

        $achatVerif = 0;
        if(isset($_POST["achatVerif"])){
            if($_POST["achatVerif"] == "verifie"){
                $achatVerif = 1;
            }
        }

        $isAjax = false;
        if(isset($_POST["isAjax"])){
            $isAjax = true;
        }

        //Insertion du nouveau commentaire
        if(!$formCommContientErreur){
            Commentaires::insererCommentaire($idClient, $isbn, $titre_commentaire, $texte_commentaire, $cote, $achatVerif);
        }

        //Informations nécéssaire pour l'affichage
        $arrCommentaires = Commentaires::trouverParISBN($isbn);
        $infosLivre = Livre::trouverParIsbn($isbn);

        //Array des données envoyées à la vue
        $arrDonnees = array_merge(
            Util::getInfosHeader(),
            array("arrCommentaires" => $arrCommentaires),
            array("livre" => $infosLivre),
            array("idClient" => $idClient),
            array("arrErreurs" => $arrErreurs),
            array("formCommContientErreur" => $formCommContientErreur)
        );

        if($isAjax){
            echo $this->blade->run("livres.fragments.commentaires", $arrDonnees);
        }
        else{
            $this->fiche($arrErreurs);
        }

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
