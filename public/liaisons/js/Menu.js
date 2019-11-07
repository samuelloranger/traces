/**
 * Classe MenuMobile
 * @description Gère le menu mobile et le
 * @author Samuel Loranger<samuelloranger@gmail.com>
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var Menu = /** @class */ (function () {
        /**
         * Constructeur de la classe
         * @description Gère ce qui arrive à l'instanciation de la classe
         */
        function Menu() {
            var _this = this;
            //Attributs de classe
            this.urlParams = new URLSearchParams(window.location.search);
            //Éléments HTML
            this.header = document.querySelector(".header");
            this.body = document.querySelector("body");
            this.conteneurMenu = this.header.querySelector(".conteneurMenu");
            this.logoTraces = Array.apply(null, document.querySelectorAll(".logoTraces"));
            this.btnMenu = document.querySelector("#btnMenuMobile");
            this.conteneneurMenu = document.querySelector(".navigation__mobile__menu");
            this.zoneLangue = document.querySelector(".zoneLangue");
            this.zoneIcones = document.querySelector(".navigation__mobile__top .zoneIcones");
            this.arrIcones = null;
            //Éléments personnalisation
            this.hauteurChangementMenuAccueil = 525;
            /**
             * Fonction ajouterEcouteursEvements
             * @description Ajoute les écouteurs d'évènements sur les éléments du menu
             */
            this.ajouterEcouteursEvements = function () {
                if (_this.urlParams.get("controleur") !== "livraison") {
                    _this.btnMenu.addEventListener("click", function () {
                        _this.gererMenuMobile();
                    });
                }
                if (_this.getPageAccueil()) {
                    _this.instancierMenuAccueil();
                    document.addEventListener("scroll", function () {
                        _this.gererMenuAccueil();
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
            this.instancierMenuAccueil = function () {
                _this.header.classList.add("header--transparent");
                _this.conteneurMenu.classList.add("conteneurMenu--grand");
                _this.logoTraces.forEach(function (logo) {
                    logo.classList.add("logoTraces--cache");
                });
            };
            /**
             * Fonction gererMenuAccueil
             * @description Gère le menu si on est sur l'accueil
             */
            this.gererMenuAccueil = function () {
                var height = window.pageYOffset;
                if (height > _this.hauteurChangementMenuAccueil) {
                    if (_this.header.classList.contains("header--transparent")) {
                        _this.header.classList.remove("header--transparent");
                        _this.conteneurMenu.classList.remove("conteneurMenu--grand");
                    }
                    _this.logoTraces.forEach(function (logo) {
                        if (logo.classList.contains("logoTraces--cache")) {
                            logo.classList.remove("logoTraces--cache");
                        }
                    });
                }
                else {
                    if (!_this.header.classList.contains("header--transparent")) {
                        _this.header.classList.add("header--transparent");
                        _this.conteneurMenu.classList.add("conteneurMenu--grand");
                    }
                    _this.logoTraces.forEach(function (logo) {
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
            this.gererMenuMobile = function () {
                if (_this.conteneneurMenu.classList.contains("navigation__mobile__menu--ferme")) {
                    if (_this.getPageAccueil()) {
                        _this.header.classList.remove("header--transparent");
                        _this.logoTraces.forEach(function (logo) {
                            if (logo.classList.contains("logoTraces--cache")) {
                                logo.classList.remove("logoTraces--cache");
                            }
                        });
                        document.removeEventListener("scroll", _this.gererMenuAccueil);
                    }
                    _this.header.classList.add("header--menuMobileOuvert");
                    _this.conteneneurMenu.classList.remove("navigation__mobile__menu--ferme");
                    _this.conteneneurMenu.classList.add("navigation__mobile__menu--ouvert");
                    _this.btnMenu.classList.add("is-active");
                    _this.zoneLangue.classList.remove("zoneLangue--inactif");
                    _this.zoneIcones.classList.add("zoneIcones--inactif");
                    _this.arrIcones.forEach(function (icone) {
                        icone.classList.add("icone--inactif");
                    });
                }
                else {
                    if (_this.getPageAccueil()) {
                        _this.header.classList.add("header--transparent");
                        _this.logoTraces.forEach(function (logo) {
                            if (!logo.classList.contains("logoTraces--cache")) {
                                logo.classList.add("logoTraces--cache");
                            }
                        });
                        document.addEventListener("scroll", _this.gererMenuAccueil);
                    }
                    _this.header.classList.remove("header--menuMobileOuvert");
                    _this.conteneneurMenu.classList.add("navigation__mobile__menu--ferme");
                    _this.conteneneurMenu.classList.remove("navigation__mobile__menu--ouvert");
                    _this.btnMenu.classList.remove("is-active");
                    _this.zoneLangue.classList.add("zoneLangue--inactif");
                    _this.zoneIcones.classList.remove("zoneIcones--inactif");
                    _this.arrIcones.forEach(function (icone) {
                        icone.classList.remove("icone--inactif");
                    });
                }
            };
            /**
             * Méthodes utilitaires
             */
            /**
             * Fonction getPageAccueil
             * @description Teste si l'utilisateur se retrouve sur la page d'accueil
             * @return boolean Vrai si l'utilisateur est sur l'accueil - Faux si l'utilisateur n'est pas sur l'accueil
             */
            this.getPageAccueil = function () {
                var controleur = _this.urlParams.get("controleur");
                var action = _this.urlParams.get("action");
                return ((controleur === "site" && action === "accueil") || (controleur == null && action == null));
            };
            this.ajouterEcouteursEvements();
            if (this.urlParams.get("controleur") !== "livraison") {
                this.arrIcones = Array.apply(null, this.zoneIcones.querySelectorAll(".icone"));
            }
        }
        return Menu;
    }());
    exports.Menu = Menu;
});
//# sourceMappingURL=Menu.js.map