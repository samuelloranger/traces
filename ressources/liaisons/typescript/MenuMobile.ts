/**
 * Classe MenuMobile
 * @description Gère le menu mobile et le
 * @author Samuel Loranger<samuelloranger@gmail.com>
 */

export class MenuMobile{
    private btnMenu:HTMLElement = document.querySelector("#btnMenuMobile");
    private conteneneurMenu:HTMLElement = document.querySelector(".navigation__mobile__menu");
    private zoneLangue:HTMLElement = document.querySelector(".zoneLangue");
    private arrIcones:Array<HTMLElement> = Array.apply(null, document.querySelectorAll(".navigation__mobile__top .zoneIcones .icone"));

    constructor(){
        this.ajouterEcouteursEvements();
    }

    private ajouterEcouteursEvements = () => {
        this.btnMenu.addEventListener("click", () => {
            this.gererMenu();
        });
    };

    private gererMenu = () => {
        if(this.conteneneurMenu.classList.contains("navigation__mobile__menu--ferme")){
            this.conteneneurMenu.classList.remove("navigation__mobile__menu--ferme");
            this.conteneneurMenu.classList.add("navigation__mobile__menu--ouvert");
            this.btnMenu.classList.add("is-active");
            this.zoneLangue.classList.remove("zoneLangue--inactif");

            this.arrIcones.forEach((icone:HTMLElement) => {
                icone.classList.add("icone--inactif");
            });
        }
        else{
            this.conteneneurMenu.classList.add("navigation__mobile__menu--ferme");
            this.conteneneurMenu.classList.remove("navigation__mobile__menu--ouvert");
            this.btnMenu.classList.remove("is-active");
            this.zoneLangue.classList.add("zoneLangue--inactif");

            this.arrIcones.forEach((icone:HTMLElement) => {
                icone.classList.remove("icone--inactif");
            });
        }
    }
}