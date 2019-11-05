/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */
import {GestionPanier} from "./GestionPanier";

export class GestionCatalogue{
    //Ajout au panier
    private btnsAjoutPanier:[HTMLElement] = Array.apply(null, document.querySelectorAll(".catalogue__btn--ajouterPanierScript"));
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

        if(controleur === "livre" && action === "catalogue" || controleur === null && action === null){
            this.btnsAjoutPanier.forEach((element) => {
                element.addEventListener("click", () => {
                    this.ajoutPanier(element);
                });
            })
        }
    };

    private ajoutPanier = (element) => {
        const isbnLivre = element.value;
        const panier =  this.panier;

        $.ajax({
            url: "index.php?controleur=panier&action=ajoutPanier&redirection=aucune&isbn=" + isbnLivre,
            type: "POST",
            data: "&qte=1",
            dataType: "html"
        })
            .done(function(data, textStatus, jqXHR){
                    panier.majItemPanierHeader(data, textStatus, jqXHR);
                    panier.montrerFenetreModale(isbnLivre);
                }
            )
    };
}