/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */

export class GestionPanier {
    private selecteurFraisLivraison:HTMLElement = document.querySelector("#fraisLivraisonSelect");

    private iconePanier:HTMLElement = document.querySelector(".iconePanier");
    private nbrItemsPanier:[HTMLElement] = Array.apply(null, document.querySelectorAll(".nbrItemsPanier"));
    private arrBtnSupprimer:[HTMLInputElement] = null;
    private urlParams = new URLSearchParams(window.location.search);

    constructor(){
        this.initialiser();
    }

    private initialiser = () => {
        this.ajouterEcouteursEvenements();
    };

    private ajouterEcouteursEvenements = () => {

        this.arrBtnSupprimer = Array.apply(null, document.querySelectorAll(".lienSupprItemScript"));

        const controleur = this.urlParams.get('controleur');
        const action = this.urlParams.get('action');

        if(controleur === "panier" && action === "panier"){
            this.arrBtnSupprimer.forEach((element) => {
                element.addEventListener("click", () => {
                    this.supprimerItemPanier(element.value);
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
    public majItemPanierHeader(data, textStatus, jqXHR){
        //On parse le retour de data en json
        //On va chercher la quantité retournée par le call Ajax
        const nbrItems = data;

        this.nbrItemsPanier.forEach((element) => {
            if(element == null){
                const elementHTMLNbrItems = document.createElement("span");
                const valeurNbrItems = document.createTextNode(nbrItems);

                elementHTMLNbrItems.classList.add("nbrItemsPanier");
                elementHTMLNbrItems.appendChild(valeurNbrItems);

                this.iconePanier.append(elementHTMLNbrItems);
                this.nbrItemsPanier.push(document.querySelector(".nbrItemsPanier"));
            }
            else{
                element.innerHTML = nbrItems;
            }
        });
    }

    private majPanier = (data, textStatus, jqXHR) => {

    };

    private supprimerItemPanier(isbnLivre:string){
        const panier = this;
        console.log(isbnLivre);

        $.ajax({
            url: "index.php?controleur=panier&action=ajoutPanier&redirection=aucune&isbn=",
            type: "POST",
            data: "",
            dataType: "html"
        })
            .done(function(data, textStatus, jqXHR){
                panier.majPanier(data, textStatus, jqXHR);
            }
        )
    }
}