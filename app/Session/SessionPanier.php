<?php
declare(strict_types=1);

namespace App\Session;

use App\Modeles\Livre;
use App\App;

class SessionPanier
{
    private $items = [];
    private $session = null;

    public function __construct(){
        $this->session = App::getInstance()->getSession();
    }

    // Ajoute un item au panier avec la qantité X
    // Attention: Si l'item existe déjà dans le panier alors mettre à jour la quantité (la quantité maximum est de 10 à valider...)
    public function ajouterItem(Livre $unLivre, int $uneQte):void
    {
        $this->items = $this->getItems();

        $livreAjoute = new SessionItem($unLivre, $uneQte);

        $livreExiste = false;
        forEach($this->items as $item){
            if($livreAjoute->livre->isbn === $item->livre->isbn){
                $livreExiste = true;
            }
        }

        if($livreExiste){
            if(($this->getQuantiteItem($livreAjoute->__get("livre")->isbn) + $uneQte) <= 10){
                $this->setQuantiteItem($livreAjoute->__get("livre")->isbn, $this->getQuantiteItem($livreAjoute->__get("livre")->isbn) + $uneQte);
            }
            else{
                $this->setQuantiteItem($livreAjoute->__get("livre")->isbn, 10);
            }
        }
        else{
            $this->items[$livreAjoute->__get("livre")->isbn] = $livreAjoute;
        }

        //Sauvegarde du panier
        $this->sauvegarder();
    }

    // Supprimer un item du panier
    public function supprimerItem(string $isbn):void
    {
        $this->items = $this->getItems();

        unset($this->items[$isbn]);

        //Sauvegarde du panier
        $this->sauvegarder();
    }

    // Retourner le tableau d'items du panier
    public function getItems():array
    {
        if($this->session->getItem("panier") != null){
            return $this->session->getItem("panier");
        }
        else{
            return array();
        }
    }

    // Mettre à jour la quantité d'un item
    public function setQuantiteItem(string $isbn, int $uneQte):void
    {
        $this->items = $this->getItems();


        $this->items[$isbn]->quantite = $uneQte;

        //Sauvegarde du panier
        $this->sauvegarder();
    }

    // Retourner la quantité d'un item
    public function getQuantiteItem(string $isbn):int
    {
        return intval($this->items[$isbn]->__get("quantite"));
    }


    // Retourner le nombre d'item différents (unique) dans le panier
    public function getNombreTotalItemsDifferents():int
    {
        $nbrItemsDifferents = 0;
        $dernierItem = null;
        forEach($this->items as $item){
            if($item === $dernierItem){
                $nbrItemsDifferents++;
            }
            $dernierItem = $item;
        }
        return $nbrItemsDifferents;
    }

    // Retourner le nombre de livres total dans le panier (somme de la quantité de chaque item)
    private function getNombreTotalItems():int
    {
        $this->items = $this->getItems();

        $nombreTotalItems = 0;
        forEach($this->items as $item){
            $nombreTotalItems += $item->quantite;
        }
        return $nombreTotalItems;
    }


    // Retourner le montant sousTotal du panier (somme des montantTotals de chaque item)
    public function getMontantSousTotal():float{
        $this->items = $this->getItems();

        $montantSousTotal = 0;
        forEach($this->items as $item){
            $montantSousTotal += $item->getMontantTotal();
        }

        return round($montantSousTotal, 2);
    }


    // Retourner de montant de la TPS
    // TPS = 5%
    public function getMontantTPS():float{
        // À faire...
        return 0.05*$this->getMontantSousTotal();
    }


    // Retourner le montant des frais de livraison
    // Frais de livraison (base=4$ + taux par item=3,50$) Exemple, 1livre=7,50$, 2livres=11$ etc.
    // Il n’y a pas de taxes sur les frais de livraison. Ils s’ajoutent en dernier.
    public function getMontantFraisLivraison():float
    {
        return 4 + (3.50*$this->getNombreTotalItems());
    }

    // Retourner le montant total de la commande (montant sous-total + TPS + montant livraison)
    public function getMontantTotal():float
    {
        $montantTotal = $this->getMontantTPS() + $this->getMontantSousTotal() + $this->getMontantFraisLivraison();
        return round($montantTotal, 2);
    }


    // Sauvegarder le panier en variable session nommée: panier
    public function sauvegarder():void
    {
        $this->session->setItem("panier", $this->items);
    }

    // Supprimer le panier en variable session nommée: panier
    public function supprimer(){
        $this->session->supprimerItem("panier");
    }

}
