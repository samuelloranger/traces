/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */

export class GestionPanier {
    //Éléments définis une seule fois
    private urlParams = new URLSearchParams(window.location.search);
    private iconesPanier:[HTMLElement] = Array.apply(null, document.querySelectorAll(".iconePanier"));
    private fenetreModale:HTMLElement = document.querySelector(".modaleItemAjoute");
    private btnFermerFenetreModale:HTMLElement = document.querySelector("#btnFermerFenetreModale");
    private timeOutFenetreModale = null;

    //Éléments redéfinis
    private selecteurFraisLivraison:HTMLInputElement = document.querySelector("#fraisLivraisonSelect");
    private nbrsItemsPanier:[HTMLElement] = Array.apply(null, document.querySelectorAll(".nbrItemsPanier"));
    private selecteursQteLivre:[HTMLInputElement] = Array.apply(null, document.querySelectorAll(".qteItem"));
    private arrBtnSupprimer:[HTMLInputElement] = Array.apply(null, document.querySelectorAll(".lienSupprItemScript"));

    /**
     * Constructeur
     * @description ajoute les écouteurs d'évènements à l'instanciation
     */
    constructor(){
        this.ajouterEcouteursEvenements();
    }

    /**
     * Fonction ajouterEcouteursEvenements
     * @description
     */
    private ajouterEcouteursEvenements = () => {
        this.selecteurFraisLivraison = document.querySelector("#fraisLivraisonSelect");
        this.arrBtnSupprimer = Array.apply(null, document.querySelectorAll(".lienSupprItemScript"));
        this.nbrsItemsPanier = Array.apply(null, document.querySelectorAll(".nbrItemsPanier"));
        this.selecteursQteLivre = Array.apply(null, document.querySelectorAll(".qteItem"));

        const controleur = this.urlParams.get('controleur');
        const action = this.urlParams.get('action');

        //Si on est presentement dans le panier
        if(controleur === "panier" && action === "panier"){
            /**
             * Suspression d'un item
             */
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

            this.selecteurFraisLivraison.addEventListener("change", () =>{
                this.changerFraisLivraison(this.selecteurFraisLivraison.value);
            });
        }

        this.btnFermerFenetreModale.addEventListener("click", () => {
            this.toggleFenetreModale("fermer");
        });
    };

    /**
     * Fonction majItemPanierHeader
     * @description Mets à jour le nombre d'items dans le panier dans le header du site
     * @param data
     * @param textStatus
     * @param jqXHR
     */
    public majItemPanierHeader = (data, textStatus, jqXHR) =>{
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
    };

    /**
     * Fonction montrerFenetreModale
     * @description Retourne les information du livre
     * @param isbn String du isbn envoyé au PHP
     */
    public montrerFenetreModale = (isbn:string) => {
        $.ajax({
            url: "index.php?controleur=livre&action=fenetreModale",
            type: "POST",
            data: "isbn=" + isbn,
            dataType: "html",
        })
            .done((data, textStatus, jqXHR) => {
                this.changerInfosFenetreModale(data, textStatus, jqXHR)
            });
    };

    /**
     * Fonction changerInfosFenetreModale
     * @description Change les informations de la fenêtre modale
     * @param data
     * @param textStatus
     * @param jqXHR
     */
    public changerInfosFenetreModale = (data, textStatus, jqXHR) => {
        const infosLivre = JSON.parse(data);

        const titre:string = infosLivre["titre"];
        const url:string = infosLivre["url"];
        const prix:string = parseFloat(infosLivre["prix"]).toFixed(2) + " $";
        const sousTotal:string = parseFloat(infosLivre["sous-total"]).toFixed(2) + " $";

        const zoneTitre:HTMLElement = this.fenetreModale.querySelector(".infos__titre");
        const zonePrix:HTMLElement = this.fenetreModale.querySelector(".infos__prix");
        const image:HTMLImageElement = this.fenetreModale.querySelector(".image");
        const zoneSousTotal:HTMLElement = this.fenetreModale.querySelector(".sous-total");

        zoneTitre.innerHTML = titre;
        image.src = url;
        zonePrix.innerHTML = prix;
        zoneSousTotal.innerHTML = sousTotal;

        this.toggleFenetreModale("ouvrir");
    };

    /**
     *
     */
    public toggleFenetreModale = (action:string) => {
        if(action == "ouvrir"){
            this.fenetreModale.classList.remove("modaleItemAjoute--inactive");
            this.timeOutFenetreModale = setTimeout(() => {
                this.toggleFenetreModale("fermer")
            }, 5000);
        }
        else{
            this.fenetreModale.classList.add("modaleItemAjoute--inactive");
            this.timeOutFenetreModale = null;
        }
    };

    /**
     * Fonction majPanier
     * @description Met à jour la fiche du panier (tous les prix/livres)
     * @param data
     * @param textStatus
     * @param jqXHR
     */
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
                });
    };

    /**
     * Fonction majQteItem
     * @description Mets à jour la quantité de l'item sélectionné
     * @param element L'item sélectionné
     * @param qte La nouvelle quantité du livre
     */
    private majQteItem = (element:HTMLInputElement, qte:Number) => {
        const panier = this;
        let livre:HTMLInputElement = element.parentElement.parentElement.parentElement.querySelector(".isbn");
        const isbn = livre.value;

        $.ajax({
            url: "index.php?controleur=panier&action=updateItem",
            type: "POST",
            data: "isbn=" + isbn + "&qte=" + qte + "&isAjax=true",
            dataType: "html"
        })
            .done(function(data, textStatus, jqXHR){
                    panier.majPanier(data, textStatus, jqXHR);
                });
    };


    /**
     * Fonction supprimerItemPanier
     * @description Supprime un livre du panier
     * @param isbnLivre isbn du livre à supprimer
     */
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
            });
    };

    /**
     * Fonction changerFraisLivraison
     * @param modeLivraison string du mode de livraison envoyé au PHP qui vient du select
     */
    private changerFraisLivraison = (modeLivraison) => {
        const panier = this;

        $.ajax({
            url: "index.php?controleur=panier&action=panier",
            type: "POST",
            data: "modeLivraison=" + modeLivraison,
            dataType: "html"
        })
            .done((data, textStatus, jqXHR) => {
                panier.majPanier(data, textStatus, jqXHR);
                this.ajouterEcouteursEvenements();
            });
    };
}