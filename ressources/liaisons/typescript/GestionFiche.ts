/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */
import {GestionPanier} from "./GestionPanier";
import {CommentairesEtoiles} from "./CommentairesEtoiles";

export class GestionFiche {

    //Sélecteurs de quantité
    private btnSoustraire:HTMLElement = document.querySelector(".btnChangementQte__soustraire");
    private btnAjouter:HTMLElement = document.querySelector(".btnChangementQte__additionner");
    private selecteurQte:HTMLInputElement = document.querySelector(".qteCourante");

    //Commentaire du livre
    private zoneCommentaires:HTMLElement = document.querySelector(".zoneCommentaires");
    private formulaireNouveauCommentaire:HTMLElement = document.querySelector(".formulaireNouveauCommentaire");
    private elementsFormCommentaire:[HTMLInputElement] = null;
    private boutonEnvoyerCommentaire:HTMLInputElement = null;

    private boutonEnvoyerCommentaireActive = false;
    private etatElementsFormulaire = [];

    //Ajout au panier
    private btnAjoutPanier:HTMLElement = document.querySelector(".btnAjoutPanierScript");
    private urlParams = new URLSearchParams(window.location.search);

    //Attributs de classe
    private panier:GestionPanier = null;
    private etoilesCommentaires:CommentairesEtoiles = null;

    constructor(panier:GestionPanier, etoilesCommentaires:CommentairesEtoiles){
        this.panier = panier;
        this.ajouterEcouteursEvenements();
        this.etoilesCommentaires = etoilesCommentaires;
    }


    /**
     * Fonction ajouterEcoutersEvenements
     * @description Ajoute les écouteurs d'evenements sur les bons elements
     */
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

            this.elementsFormCommentaire = Array.apply(null, this.formulaireNouveauCommentaire.querySelectorAll(".elementFormCommentaire"));
            this.boutonEnvoyerCommentaire = this.formulaireNouveauCommentaire.querySelector(".boutonEnvoyerCommentaireScript");

            // Bouton envoyer un commentaire
            this.boutonEnvoyerCommentaire.addEventListener("click", () => {
                this.envoyerCommentaire();
            });

            //Éléments des commentaires
            this.elementsFormCommentaire.forEach((element) => {
                if(element.type !== "hidden" && !element.classList.contains("elementFormCommentaire--nonObligatoire")){
                    this.etatElementsFormulaire[element.id] = false;

                    element.addEventListener("change", () => {
                        this.verifierElementCommentaire(element);
                    });

                    element.addEventListener("keyup", () => {
                        this.verifierElementCommentaire(element);
                    });
                }
            });
        }
    };

    /**
     * Fonction changerQte
     * @description Fait une opération sur la quantité des livres à ajouter au panier
     * @param operation Définit l'peration devrait être faite sur la quantité des livres
     */
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

    /**
     * Fonction verifierQteEntree
     * @description Vérrifie si la quntité entrée est correcte
     */
    private verifierQteEntree = () => {
        if(Number(this.selecteurQte.value) > 10){
            this.selecteurQte.value = "10";
        }

        if(this.selecteurQte.value == "" || Number(this.selecteurQte.value) == 0 || Number(this.selecteurQte.value) < 0){
            this.selecteurQte.value = "1";
        }
    };

    /**
     * Fonction ajoutPanier
     * @description Ajoute l'item au panier
     */
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
    };

    /**
     * Fonction verifierElementCommentaire
     * @description Vérifie si le contenu entré dans le formulaire est correct
     * @param element Élément qui est testé
     */
    private verifierElementCommentaire = (element) => {
        let erreur = false;

        switch(element.type){
            case "text":
                erreur = element.value.length === 0 || element.value.length < 10 || element.value.length > 50;
                break;
            case "textarea":
                erreur = element.value.length === 0 || element.value.length < 50 || element.value.length > element.maxLength;
                this.changerCaracteresRestants(element);
                break;
            case "number":
                erreur = element.value < 1 || element.value > 5;
                break;
            default:
                break;
        }

        if(erreur){
            this.erreurElementCommentaire(element, "afficher");
        }
        else{
            this.erreurElementCommentaire(element, "retirer");
            this.etatElementsFormulaire[element.id] = true;
        }

        this.verifirerTousElementsCommentaire();
    };

    private changerCaracteresRestants = (element) => {
        const caracteresMax = element.maxLength;
        const zoneCarRestants = element.parentNode.querySelector(".caracteresRestants");
        zoneCarRestants.innerHTML = caracteresMax - element.value.length;
    };

    /**
     * Fonction verifierTousElementsCommentaire
     * @description Vérifie si tous les éléments du formulaire sont ok
     * S'il y en a un qui n'est pas ok, il n'active pas le bouton d'envoi
     */
    private verifirerTousElementsCommentaire = () => {
        let tousChampsValides = true;

        this.elementsFormCommentaire.forEach((element) => {
            if(this.etatElementsFormulaire[element.id] === false){
                tousChampsValides = false;
            }
        });

        if(tousChampsValides){
            this.activerDesactiverBtnEnvoyer("activer");
        }
    };

    /**
     * Fonction erreurelementCommentaire
     * @description Affiche l'erreur sur l'élément qui n'est pas correct
     * @param element L'élément à faire une opération
     * @param action L'action à effectuer sur cet élément
     */
    private erreurElementCommentaire = (element:HTMLInputElement, action:string) => {
        action === "afficher" ? element.classList.add("elementFormCommentaire--erreur") : element.classList.remove("elementFormCommentaire--erreur");
    };

    /**
     * Fonction activerDesactiverBtnEnvoyer
     * @description Active ou désactive le bouton d'envoi
     * @param action Action à effectuer sur le bouton
     */
    private activerDesactiverBtnEnvoyer = (action:string) => {
        action === "activer" ? this.boutonEnvoyerCommentaire.removeAttribute("disabled") : this.boutonEnvoyerCommentaire.setAttribute("disabled", "disabled");
        this.boutonEnvoyerCommentaireActive = true;
    };

    /**
     * Fonction envoyerCommentaire
     * @description Envoie le commentaire au serveur et attend le retour
     */
    private envoyerCommentaire = () => {
        const fiche = this;

        let stringData = "";

        this.elementsFormCommentaire.forEach((element) => {
            stringData += element.id + "=" + element.value + "&";
        });

        stringData += "isAjax";

        if(this.boutonEnvoyerCommentaireActive){
            $.ajax({
                url: "index.php?controleur=livre&action=ajouterCommentaire",
                type: "POST",
                data: stringData,
                dataType: "html"
            })
                .done(function(data, textStatus, jqXHR){
                        //fonction
                        fiche.afficherCommentaires(data, textStatus, jqXHR);
                    }
                );
        }
    };

    /**
     * Fonction afficherCommentaires
     * @param data Est le data qui est revenu du PHP (Qui normalement devrait être la zone des commentaires de la vue modifiée
     * @param textStatus
     * @param jqXHR
     */
    private afficherCommentaires = (data, textStatus, jqXHR) => {
        this.zoneCommentaires.innerHTML = data;
        this.etoilesCommentaires.recharger();
    }
}