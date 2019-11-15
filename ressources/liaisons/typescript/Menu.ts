/**
 * Classe MenuMobile
 * @description Gère le menu mobile et le
 * @author Samuel Loranger<samuelloranger@gmail.com>
 */

export class Menu {
    //Attributs de classe
    private urlParams: URLSearchParams = new URLSearchParams(window.location.search);

    //Éléments HTML
    private header: HTMLElement = document.querySelector(".header");
    private body: HTMLElement = document.querySelector("body");
    private conteneurMenu: HTMLElement = this.header.querySelector(".conteneurMenu");
    private logoTraces: Array<HTMLElement> = Array.apply(null, document.querySelectorAll(".logoTraces"));
    private btnMenu: HTMLElement = document.querySelector("#btnMenuMobile");
    private conteneneurMenu: HTMLElement = document.querySelector(".navigation__mobile__menu");
    private zoneLangue: HTMLElement = document.querySelector(".zoneLangue");
    private zoneIcones: HTMLElement = document.querySelector(".navigation__mobile__top .zoneIcones");

    private arrIcones: Array<HTMLElement> = null;

    private inputRecherche: HTMLInputElement[] = Array.apply(null, document.querySelectorAll(".inputRecherche"));
    private zoneRecherche: HTMLElement[] = Array.apply(null, document.querySelectorAll(".zoneRecherche"));
    private iconeRecherche: HTMLElement[] = Array.apply(null, document.querySelectorAll(".icone__rechercher"));
    private btnFermerRecherche: HTMLElement[] = Array.apply(null, document.querySelectorAll(".fermerZoneRecherche"));
    private conteneurZoneRecherche: HTMLElement[] = Array.apply(null, document.querySelectorAll(".conteneurZoneRecherche"));

    //Éléments personnalisation
    private hauteurChangementMenuAccueil = 525;

    /**
     * Constructeur de la classe
     * @description Gère ce qui arrive à l'instanciation de la classe
     */
    constructor() {
        this.ajouterEcouteursEvements();

        if (this.urlParams.get("controleur") !== "livraison") {
            this.arrIcones = Array.apply(null, this.zoneIcones.querySelectorAll(".icone"));
        }
    }

    /**
     * Fonction ajouterEcouteursEvements
     * @description Ajoute les écouteurs d'évènements sur les éléments du menu
     */
    private ajouterEcouteursEvements = () => {
        if (this.urlParams.get("controleur") !== "livraison" || this.urlParams.get("controleur") !== "facturation" || this.urlParams.get("controleur") !== "validation") {
            this.btnMenu.addEventListener("click", () => {
                this.gererMenuMobile();
            });

            this.inputRecherche.forEach((element) => {
                element.addEventListener("keyup", () => {
                    this.executerAjax(element);
                });
            });

            this.iconeRecherche.forEach((element) => {
                element.addEventListener("click", () => {
                    this.ouvrirFermerRecherche();
                });
            });

            this.btnFermerRecherche.forEach((element) => {
                element.addEventListener("click", () => {
                    this.ouvrirFermerRecherche();
                });
            });
        }

        if (this.getPageAccueil()) {
            this.instancierMenuAccueil();

            document.addEventListener("scroll", () => {
                this.gererMenuAccueil()
            });
        }
    };

    /**
     * Méthodes
     */
    /**
     * Fonction instancierMenuAccueil
     * @description Gère l'instanciation du menu si on est sur la page d'accueil
     */
    private instancierMenuAccueil = () => {
        this.header.classList.add("header--transparent");
        this.conteneurMenu.classList.add("conteneurMenu--grand")

        this.logoTraces.forEach((logo) => {
            logo.classList.add("logoTraces--cache");
        });
    };

    /**
     * Fonction gererMenuAccueil
     * @description Gère le menu si on est sur l'accueil
     */
    private gererMenuAccueil = () => {
        const height = window.pageYOffset;

        if (height > this.hauteurChangementMenuAccueil) {
            if (this.header.classList.contains("header--transparent")) {
                this.header.classList.remove("header--transparent");
                this.conteneurMenu.classList.remove("conteneurMenu--grand")
            }
            this.logoTraces.forEach((logo) => {
                if (logo.classList.contains("logoTraces--cache")) {
                    logo.classList.remove("logoTraces--cache");
                }
            });
        } else {
            if (!this.header.classList.contains("header--transparent")) {
                this.header.classList.add("header--transparent");
                this.conteneurMenu.classList.add("conteneurMenu--grand")
            }

            this.logoTraces.forEach((logo) => {
                if (!logo.classList.contains("logoTraces--cache")) {
                    logo.classList.add("logoTraces--cache");
                }
            });
        }
    };

    /**
     * Fonction gererMenuMobile
     * @description Gère les actions du menu mobile
     */
    private gererMenuMobile = () => {
        if (this.conteneneurMenu.classList.contains("navigation__mobile__menu--ferme")) {
            if (this.getPageAccueil()) {
                this.header.classList.remove("header--transparent");
                this.logoTraces.forEach((logo) => {
                    if (logo.classList.contains("logoTraces--cache")) {
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

            this.arrIcones.forEach((icone: HTMLElement) => {
                icone.classList.add("icone--inactif");
            });
        } else {
            if (this.getPageAccueil()) {
                this.header.classList.add("header--transparent");
                this.logoTraces.forEach((logo) => {
                    if (!logo.classList.contains("logoTraces--cache")) {
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

            this.arrIcones.forEach((icone: HTMLElement) => {
                icone.classList.remove("icone--inactif");
            });
        }
    };

    private ouvrirFermerRecherche(): void {
        this.conteneurZoneRecherche.forEach((element) => {
            if (element.classList.contains("conteneurZoneRecherche--ferme")) {
                element.classList.remove("conteneurZoneRecherche--ferme");
            } else {
                element.classList.add("conteneurZoneRecherche--ferme");
            }
        });
    }

    //////////////////////////////////////////
    // AJAX DU MANDAT B - ZACHARY NICOL-P. //
    ////////////////////////////////////////
    private executerAjax = (element: HTMLInputElement): void => {
        const stringRecherche = element.value;
        const classe = this;

        $.ajax({
            url: "index.php?controleur=site&action=recherche",
            method: "POST",
            data: "recherche=" + stringRecherche,
            dataType: "html",
        })
            .done(function (data, textStatus, jqXHR) {
                classe.retournerRecherche(data, textStatus, jqXHR);
            });
    };

    private retournerRecherche = (data, textStatus, jqXHR): void => {
        this.zoneRecherche.forEach((element) => {
            element.innerHTML = data;
        });
    };

    /**
     * Méthodes utilitaires
     */

    /**
     * Fonction getPageAccueil
     * @description Teste si l'utilisateur se retrouve sur la page d'accueil
     * @return boolean Vrai si l'utilisateur est sur l'accueil - Faux si l'utilisateur n'est pas sur l'accueil
     */
    private getPageAccueil = (): boolean => {
        const controleur = this.urlParams.get("controleur");
        const action = this.urlParams.get("action");

        return ((controleur === "site" && action === "accueil") || (controleur == null && action == null));
    }
}