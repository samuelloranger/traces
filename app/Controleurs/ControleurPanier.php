<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Modeles\Livre;
use App\Util;

class ControleurPanier{
    private $blade = null;
    private $panier = null;
    private $session = null;

    public function __construct(){
        $this->blade = App::getInstance()->getBlade();
        $this->panier = App::getInstance()->getPanier();
        $this->session = App::getInstance()->getSession();
    }

    public function ajoutPanier(){
        $isbn = "0";
        if(isset($_GET["isbn"]) && isset($_POST["qte"])){
            $isbn = $_GET["isbn"];
            $qte = intval($_POST["qte"]);

            $livre = Livre::trouverParIsbn($isbn);
            $this->panier->ajouterItem($livre, $qte);
        }

        //Validation de la redirection
        if(isset($_GET["redirection"])){
            $redirection = $_GET["redirection"];
        }

        //Redirection selon l'emplacement de la fonction appellée
        switch($redirection) {
            case "catalogue":
                header("Location: index.php?controleur=livre&action=catalogue");
                break;
            case "accueil":
                header("Location: index.php");
                break;
            case "fiche":
                header("Location: index.php?controleur=livre&action=fiche&isbn=" . $isbn);
                break;
            case "panier":
                header("Location: index.php?controleur=panier&action=panier");
                break;
            case "aucune":
                $this->retournerNbrItemsPanier();
                break;
            default:
                break;
        }
    }

    public function retournerNbrItemsPanier(){
        echo Util::getInfosPanier()["nbrItemsPanier"];
    }

    public function updateItem(){
        if(isset($_POST["isbn"])){
            $isbn = $_POST["isbn"];
        }
        else{
            $isbn = "-1";
        }

        $qte = 0;
        if(isset($_POST["qte"])){
            $qte = intval($_POST["qte"]);
        }

        $isAjax = false;
        if(isset($_POST["isAjax"])){
            $isAjax = true;
        }

        if(Util::validerISBN($isbn)){
            if($qte != 0){
                $this->panier->setQuantiteItem($isbn, $qte);

                if(!$isAjax){
                    header("Location: index.php?controleur=panier&action=panier");
                }
                else{
                    $this->panier(false);
                }
            }
            else{
                $this->supprimerItem($isbn);
            }

        }
        else{
            echo "Erreur isbn non-valide";
        }
    }

    public function supprimerItem($isbnArgument = 0){
        if(isset($_GET["isbn"])){
            $isbn = $_GET["isbn"];
        }
        else{
            if($isbnArgument != 0){
                $isbn = $isbnArgument;
            }
            else{
                $isbn = "-1";
            }
        }

        $ajaxCall = false;
        if(isset($_POST["isAjax"])){
            $ajaxCall = true;
        }

        if(Util::validerISBN($isbn)){
            $this->panier->supprimerItem($isbn);

            if(!$ajaxCall){
                header("Location: index.php?controleur=panier&action=panier");
            }
            else{
                $this->panier(false);
            }
        }
        else{
            echo "Erreur isbn non-valide";
        }
    }

    public function panier($pageComplete = true){

        //Éléments à afficher
        $itemsPanier = $this->panier->getItems();
        $montantSousTotal = Util::formaterArgent($this->panier->getMontantSousTotal());
        $montantTPS = Util::formaterArgent($this->panier->getMontantTPS());

        /**
         * Frais de livraison
         */
        if(isset($_POST["modeLivraison"])){
            $modeLivraison = $_POST["modeLivraison"];
            $dateLivraisonEstimee = "Aucune date de livraison estimée.";

            if($modeLivraison == "payante"){
                $pageComplete = false;
                $fraisLivraison = Util::formaterArgent($this->panier->getMontantFraisLivraison());
                $montantTotal = Util::formaterArgent($this->panier->getMontantTotal());
                $dateLivraisonEstimee = strftime("%A %d %B %Y", strtotime("3 days"));
            }
            elseif($modeLivraison == "gratuite"){
                $pageComplete = false;
                $fraisLivraison = Util::formaterArgent(0);
                $montantTotal = Util::formaterArgent($this->panier->getMontantTotal(false));
                $dateLivraisonEstimee = strftime("%A %d %B %Y", strtotime("7 days"));
            }

            $this->session->setItem("dateLivraisonEstimee", $dateLivraisonEstimee);
        }
        else{
            $modeLivraison = "payante";
            $fraisLivraison = Util::formaterArgent($this->panier->getMontantFraisLivraison());
            $montantTotal = Util::formaterArgent($this->panier->getMontantTotal());
            $dateLivraisonEstimee = strftime("%A %d %B %Y", strtotime("3 days"));
        }


        $tDonnees = array_merge(
            Util::getInfosHeader(),
            array("elementsPanier" => $itemsPanier),
            array("fraisLivraison" => $fraisLivraison),
            array("montantTPS" => $montantTPS),
            array("montantSousTotal" => $montantSousTotal),
            array("dateLivraisonEstimee" => $dateLivraisonEstimee),
            array("modeLivraison" => $modeLivraison),
            array("montantTotal" => $montantTotal)
        );

        if($pageComplete){
            echo $this->blade->run("panier.gabarit_panier", $tDonnees);
        }
        else{
            echo $this->blade->run("panier.panier", $tDonnees);
        }
    }
}
