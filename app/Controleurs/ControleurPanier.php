<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Modeles\Livre;
use App\Util;
use DateInterval;
use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Locale;

class ControleurPanier{
    private $blade = null;
    private $panier = null;

    public function __construct(){
        $this->blade = App::getInstance()->getBlade();
        $this->panier = App::getInstance()->getPanier();
    }

    public function ajoutPanier(){
        if(isset($_GET["isbn"]) && isset($_POST["qte"])){
            $isbn = $_GET["isbn"];
            $qte = intval($_POST["qte"]);

            $livre = Livre::trouverParIsbn($isbn);
            App::getInstance()->getPanier()->ajouterItem($livre, $qte);
        }

        //Validation de la redirection
        if(isset($_GET["redirection"])){
            $redirection = $_GET["redirection"];
        }

        //Redirection selon l'emplacement de la fonction appellée
        if($redirection == "catalogue"){
            header("Location: index.php?controleur=livre&action=catalogue");
        }
        elseif($redirection == "accueil"){
            header("Location: index.php");
        }
        elseif($redirection == "fiche"){
            header("Location: index.php?controleur=livre&action=fiche&isbn=" . $isbn);
        }
        else{
            header("Location: index.php?controleur=panier&action=panier");
        }
    }

    public function updateItem(){
        if(isset($_GET["isbn"])){
            $isbn = $_GET["isbn"];
        }
        else{
            $isbn = "-1";
        }

        $qte = 0;
        if(is_numeric($_GET["qte"])){
            $qte = intval($_GET["qte"]);
        }


        if(Util::validerISBN($isbn)){
            if($qte != 0){
                $this->panier->setQuantiteItem($isbn, $qte);
            }
            else{
                $this->supprimerItem();
            }
            header("Location: index.php?controleur=panier&action=panier");
        }
        else{

            echo "Erreur isbn non-valide";
        }
    }

    public function supprimerItem(){
        if(isset($_GET["isbn"])){
            $isbn = $_GET["isbn"];
        }
        else{
            $isbn = "-1";
        }

        if(Util::validerISBN($isbn)){
            $this->panier->supprimerItem($isbn);

            header("Location: index.php?controleur=panier&action=panier");
        }
        else{
            echo "Erreur isbn non-valide";
        }
    }

    public function panier():void{

        //Éléments à afficher
        $itemsPanier = $this->panier->getItems();
        $montantSousTotal = Util::formaterArgent($this->panier->getMontantSousTotal());
        $fraisLivraison = Util::formaterArgent($this->panier->getMontantFraisLivraison());
        $montantTPS = Util::formaterArgent($this->panier->getMontantTPS());
        $montantTotal = Util::formaterArgent($this->panier->getMontantTotal());

        /**
         * Dates de livraison
         */
        $dateLivraisonEstimee = strftime("%A %d %B %Y", strtotime("3 days"));
        $typeLivraison = "payante";

        if(isset($_GET["livraisonGratuite"])){
            $dateLivraisonEstimee = strftime("%A %d %B %Y", strtotime("7 days"));
            $typeLivraison = "gratuite";
            $fraisLivraison = "0.00 $";
            $montantTotal = Util::formaterArgent($this->panier->getMontantTotal(false));
        }

        $tDonnees = array_merge(
            Util::getInfosPanier(),
            array("elementsPanier" => $itemsPanier),
            array("fraisLivraison" => $fraisLivraison),
            array("montantTPS" => $montantTPS),
            array("montantSousTotal" => $montantSousTotal),
            array("dateLivraisonEstimee" => $dateLivraisonEstimee),
            array("typeLivraison" => $typeLivraison),
            array("montantTotal" => $montantTotal)
        );

        echo $this->blade->run("panier.panier", $tDonnees);
    }
}
