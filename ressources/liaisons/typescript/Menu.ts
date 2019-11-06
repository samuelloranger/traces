/**
 * Classe MenuMobile
 * @description Gère le menu mobile et le
 * @author Samuel Loranger<samuelloranger@gmail.com>
 */

export class Menu{
    //Éléments HTML
    private header:HTMLElement = document.querySelector(".header");
    private body:HTMLElement = document.querySelector("body");
    private conteneurMenu:HTMLElement = this.header.querySelector(".conteneurMenu");
    private logoTraces:Array<HTMLElement> = Array.apply(null, document.querySelectorAll(".logoTraces"));
    private btnMenu:HTMLElement = document.querySelector("#btnMenuMobile");
    private conteneneurMenu:HTMLElement = document.querySelector(".navigation__mobile__menu");
    private zoneLangue:HTMLElement = document.querySelector(".zoneLangue");
    private zoneIcones:HTMLElement = document.querySelector(".navigation__mobile__top .zoneIcones");
    private arrIcones:Array<HTMLElement> = Array.apply(null, this.zoneIcones.querySelectorAll(".icone"));

    //Éléments personnalisation
    private hauteurChangementMenuAccueil = 525;

    private urlParams:URLSearchParams = new URLSearchParams(window.location.search);

    constructor(){
        this.ajouterEcouteursEvements();
    }

    private ajouterEcouteursEvements = () => {
        this.btnMenu.addEventListener("click", () => {
            this.gererMenuMobile();
        });

        if(this.getPageAccueil()){
            this.instancierMenuAccueil();

            document.addEventListener("scroll", () =>{
                this.gererMenuAccueil();
            });
        }
    };

    /**
     * Méthodes
     */
    private instancierMenuAccueil = () => {
        if(this.getPageAccueil()){
            this.header.classList.add("header--transparent");
            this.conteneurMenu.classList.add("conteneurMenu--grand")

            this.logoTraces.forEach((logo) => {
                logo.classList.add("logoTraces--cache");
            });
        }
    };


    private gererMenuAccueil = () => {
        const height = window.pageYOffset;

        console.log("test" + height);


        if(height > this.hauteurChangementMenuAccueil){
            if(this.header.classList.contains("header--transparent")){
                this.header.classList.remove("header--transparent");
                this.conteneurMenu.classList.remove("conteneurMenu--grand")
            }
            this.logoTraces.forEach((logo) => {
                if(logo.classList.contains("logoTraces--cache")) {
                    logo.classList.remove("logoTraces--cache");
                }
            });
        }
        else{
            if(!this.header.classList.contains("header--transparent")){
                this.header.classList.add("header--transparent");
                this.conteneurMenu.classList.add("conteneurMenu--grand")
            }

            this.logoTraces.forEach((logo) => {
                if(!logo.classList.contains("logoTraces--cache")) {
                    logo.classList.add("logoTraces--cache");
                }
            });
        }
    };

    private gererMenuMobile = () => {
        if(this.conteneneurMenu.classList.contains("navigation__mobile__menu--ferme")){
            if(this.getPageAccueil()){
                this.header.classList.remove("header--transparent");
                this.logoTraces.forEach((logo) => {
                    if(logo.classList.contains("logoTraces--cache")) {
                        logo.classList.remove("logoTraces--cache");
                    }
                });

                document.removeEventListener("scroll", this.gererMenuAccueil);
            }

            this.header.classList.add("header--menuMobileOuvert");
            this.conteneneurMenu.classList.remove("navigation__mobile__menu--ferme");
            this.conteneneurMenu.classList.add("navigation__mobile__menu--ouvert");
            this.btnMenu.classList.add("is-active");
            this.zoneLangue.classList.remove("zoneLangue--inactif");
            this.zoneIcones.classList.add("zoneIcones--inactif");

            this.arrIcones.forEach((icone:HTMLElement) => {
                icone.classList.add("icone--inactif");
            });
        }
        else{
            if(this.getPageAccueil()){
                this.header.classList.add("header--transparent");
                this.logoTraces.forEach((logo) => {
                    if(!logo.classList.contains("logoTraces--cache")) {
                        logo.classList.add("logoTraces--cache");
                    }
                });

                document.addEventListener("scroll", this.gererMenuAccueil);
            }

            this.header.classList.remove("header--menuMobileOuvert");
            this.conteneneurMenu.classList.add("navigation__mobile__menu--ferme");
            this.conteneneurMenu.classList.remove("navigation__mobile__menu--ouvert");
            this.btnMenu.classList.remove("is-active");
            this.zoneLangue.classList.add("zoneLangue--inactif");
            this.zoneIcones.classList.remove("zoneIcones--inactif");

            this.arrIcones.forEach((icone:HTMLElement) => {
                icone.classList.remove("icone--inactif");
            });
        }
    };


    /**
     * Méthodes utilitaires
     */
    private getPageAccueil = ():boolean => {
        const controleur = this.urlParams.get("controleur");
        const action = this.urlParams.get("action");

        return ((controleur === "site" && action === "accueil") || (controleur == null && action == null));
    }
}