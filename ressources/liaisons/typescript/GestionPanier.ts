/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */

export class GestionPanier {
    //Éléments définis une seule fois
    private urlParams = new URLSearchParams(window.location.search);
    private selecteurFraisLivraison:HTMLElement = document.querySelector("#fraisLivraisonSelect");
    private iconesPanier:[HTMLElement] = Array.apply(null, document.querySelectorAll(".iconePanier"));

    //Éléments redéfinis
    private nbrsItemsPanier:[HTMLElement] = Array.apply(null, document.querySelectorAll(".nbrItemsPanier"));
    private selecteursQteLivre:[HTMLInputElement] = Array.apply(null, document.querySelectorAll(".qteItem"));
    private arrBtnSupprimer:[HTMLInputElement] = Array.apply(null, document.querySelectorAll(".lienSupprItemScript"));

    constructor(){
        this.ajouterEcouteursEvenements();
    }

    private ajouterEcouteursEvenements = () => {
        this.arrBtnSupprimer = Array.apply(null, document.querySelectorAll(".lienSupprItemScript"));
        this.nbrsItemsPanier = Array.apply(null, document.querySelectorAll(".nbrItemsPanier"));
        this.selecteursQteLivre = Array.apply(null, document.querySelectorAll(".qteItem"));

        const controleur = this.urlParams.get('controleur');
        const action = this.urlParams.get('action');

        //Si on est presentement dans le panier
        if(controleur === "panier" && action === "panier"){
            this.arrBtnSupprimer.forEach((element) => {
                element.addEventListener("click", () => {
                    this.supprimerItemPanier(element.value);
                });
            });

            this.selecteursQteLivre.forEach((element) => {
                element.addEventListener("change", () => {
                    this.majQteItem(element, Number(element.value));
                });
            });
        }
    };

    /**
     * Mets à jour le nombre d'items dans le panier dans le header du site
     * @param data
     * @param textStatus
     * @param jqXHR
     */
    public majItemPanierHeader = (data, textStatus, jqXHR) =>{
        //On parse le retour de data en json
        //On va chercher la quantité retournée par le call Ajax
        const nbrItems = data;

        this.iconesPanier.forEach((element) => {
            if(element.querySelector(".nbrItemsPanier") == null){
                const elementHTMLNbrItems = document.createElement("span");
                const valeurNbrItems = document.createTextNode(nbrItems);
                elementHTMLNbrItems.classList.add("nbrItemsPanier");
                elementHTMLNbrItems.appendChild(valeurNbrItems);

                element.appendChild(elementHTMLNbrItems);
                this.nbrsItemsPanier.push(document.querySelector(".nbrItemsPanier"));
            }
            else {
                this.nbrsItemsPanier.forEach((element) => {
                    element.innerHTML = nbrItems;
                });
            }
        });
    }

    private majPanier = (data, textStatus, jqXHR) => {
        document.querySelector("main").innerHTML = data;

        this.ajouterEcouteursEvenements();

        const panier = this;
        $.ajax({
            url: "index.php?controleur=panier&action=nbrItemsPanier",
            type: "POST",
            data: "isAjax",
            dataType: "html"
        })
            .done(function(data, textStatus, jqXHR){
                    panier.majItemPanierHeader(data, textStatus, jqXHR);
                }
            );

    };

    private supprimerItemPanier = (isbnLivre:string) => {
        const panier = this;

        $.ajax({
            url: "index.php?controleur=panier&action=supprimerItem&isbn=" + isbnLivre,
            type: "POST",
            data: "isAjax",
            dataType: "html"
        })
            .done(function(data, textStatus, jqXHR){
                panier.majPanier(data, textStatus, jqXHR);
            }
        )
    };

    private majQteItem = (element:HTMLInputElement, qte:Number) => {
        const panier = this;
        const isbnLivre:HTMLInputElement = element.parentElement.parentElement.parentElement.querySelector(".isbn");

        $.ajax({
            url: "index.php?controleur=panier&action=updateItem",
            type: "POST",
            data: "isbn=" + isbnLivre.value + "&qte=" + qte + "&isAjax=true",
            dataType: "html"
        })
            .done(function(data, textStatus, jqXHR){
                    panier.majPanier(data, textStatus, jqXHR);
                }
            )
    };
}