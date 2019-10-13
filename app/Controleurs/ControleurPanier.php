<?php

declare(strict_types=1);
namespace App\Controleurs;

use App\App;
use App\Util;

class ControleurPanier{
    private $blade = null;
    private $panier = null;

    public function __construct(){
        $this->blade = App::getInstance()->getBlade();
        $this->panier = App::getInstance()->getPanier();
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
            $this->panier->setQuantiteItem($isbn, $qte);
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

        $tDonnees = array_merge(
            array("elementsPanier" => $itemsPanier),
            array("elementsPanier" => $itemsPanier),
            array("fraisLivraison" => $fraisLivraison),
            array("montantTPS" => $montantTPS),
            array("montantSousTotal" => $montantSousTotal),
            array("montantTotal" => $montantTotal)
        );

        echo $this->blade->run("panier.panier", $tDonnees);
    }
}
