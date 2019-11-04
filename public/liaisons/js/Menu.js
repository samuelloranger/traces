/**
 * Classe MenuMobile
 * @description Gère le menu mobile et le
 * @author Samuel Loranger<samuelloranger@gmail.com>
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var Menu = /** @class */ (function () {
        function Menu() {
            var _this = this;
            //Éléments HTML
            this.header = document.querySelector(".header");
            this.body = document.querySelector("body");
            this.conteneurMenu = this.header.querySelector(".conteneurMenu");
            this.logoTraces = Array.apply(null, document.querySelectorAll(".logoTraces"));
            this.btnMenu = document.querySelector("#btnMenuMobile");
            this.conteneneurMenu = document.querySelector(".navigation__mobile__menu");
            this.zoneLangue = document.querySelector(".zoneLangue");
            this.zoneIcones = document.querySelector(".navigation__mobile__top .zoneIcones");
            this.arrIcones = Array.apply(null, this.zoneIcones.querySelectorAll(".icone"));
            //Éléments personnalisation
            this.hauteurChangementMenuAccueil = 525;
            this.urlParams = new URLSearchParams(window.location.search);
            this.ajouterEcouteursEvements = function () {
                _this.btnMenu.addEventListener("click", function () {
                    _this.gererMenuMobile();
                });
                if (_this.getPageAccueil()) {
                    _this.instancierMenuAccueil();
                    document.addEventListener("scroll", _this.gererMenuAccueil);
                }
            };
            /**
             * Méthodes
             */
            this.instancierMenuAccueil = function () {
                if (_this.getPageAccueil()) {
                    _this.header.classList.add("header--transparent");
                    _this.conteneurMenu.classList.add("conteneurMenu--grand");
                    _this.logoTraces.forEach(function (logo) {
                        logo.classList.add("logoTraces--cache");
                    });
                }
            };
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
            this.getPageAccueil = function () {
                var controleur = _this.urlParams.get("controleur");
                var action = _this.urlParams.get("action");
                return ((controleur === "site" && action === "accueil") || (controleur == null && action == null));
            };
            this.ajouterEcouteursEvements();
        }
        return Menu;
    }());
    exports.Menu = Menu;
});
//# sourceMappingURL=Menu.js.map