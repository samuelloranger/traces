/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */
import {GestionPanier} from "./GestionPanier";

export class GestionFiche {

    //Sélecteurs de quantité
    private btnSoustraire:HTMLElement = document.querySelector(".btnChangementQte__soustraire");
    private btnAjouter:HTMLElement = document.querySelector(".btnChangementQte__additionner");
    private selecteurQte:HTMLInputElement = document.querySelector(".qteCourante");

    //Ajout au panier
    private btnAjoutPanier:HTMLElement = document.querySelector(".btnAjoutPanierScript");
    private urlParams = new URLSearchParams(window.location.search);

    //Attributs de classe
    private panier:GestionPanier = null;

    constructor(panier:GestionPanier){
        this.panier = panier;
        this.ajouterEcouteursEvenements();
    }


    private ajouterEcouteursEvenements = () => {
        // Quantité : Bouton soustraire
        const controleur = this.urlParams.get('controleur');
        const action = this.urlParams.get('action');

        if(controleur === "livre" && action === "fiche"){
            this.btnSoustraire.addEventListener("click", () => {
                this.changerQte("soustraire");
            });

            // Quantité : Bouton additionner
            this.btnAjouter.addEventListener("click", () => {
                this.changerQte("additionner");
            });

            // Quantité : Selecteur de quantité
            this.selecteurQte.addEventListener("change", () => {
                this.verifierQteEntree();
            });

            // Quantité : Bouton soustraire
            this.btnAjoutPanier.addEventListener("click", () => {
                this.ajoutPanier();
            });
        }
    };

    private changerQte = (operation:string) => {
        switch(operation){
            case "soustraire":
                if(Number(this.selecteurQte.value) > 1){
                    this.selecteurQte.value = String(Number(this.selecteurQte.value) - 1);
                }
                break;
            case "additionner":
                if(Number(this.selecteurQte.value) < 10){
                    this.selecteurQte.value = String(Number(this.selecteurQte.value) + 1);
                }
                break;
            default:
                break;
        }
    };

    private verifierQteEntree = () => {
        if(Number(this.selecteurQte.value) > 10){
            this.selecteurQte.value = "10";
        }

        if(this.selecteurQte.value == "" || Number(this.selecteurQte.value) == 0 || Number(this.selecteurQte.value) < 0){
            this.selecteurQte.value = "1";
        }
    };

    private ajoutPanier = () => {
        const isbn = this.urlParams.get('isbn');
        const panier =  this.panier;

        $.ajax({
            url: "index.php?controleur=panier&action=ajoutPanier&redirection=aucune&isbn=" + isbn,
            type: "POST",
            data: "&qte=" + this.selecteurQte.value,
            dataType: "html"
        })
            .done(function(data, textStatus, jqXHR){
                    panier.majItemPanierHeader(data, textStatus, jqXHR);
                    panier.montrerFenetreModale(isbn);
                }
            );
    }

}