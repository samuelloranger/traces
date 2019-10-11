/**
 * Classe MenuMobile
 * @description Gère le menu mobile et le
 * @author Samuel Loranger<samuelloranger@gmail.com>
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var MenuMobile = /** @class */ (function () {
        function MenuMobile() {
            var _this = this;
            this.btnMenu = document.querySelector("#btnMenuMobile");
            this.conteneneurMenu = document.querySelector(".navigation__mobile__menu");
            this.zoneLangue = document.querySelector(".zoneLangue");
            this.zoneIcones = document.querySelector(".navigation__mobile__top .zoneIcones");
            this.arrIcones = Array.apply(null, this.zoneIcones.querySelectorAll(".icone"));
            this.ajouterEcouteursEvements = function () {
                _this.btnMenu.addEventListener("click", function () {
                    _this.gererMenu();
                });
            };
            this.gererMenu = function () {
                if (_this.conteneneurMenu.classList.contains("navigation__mobile__menu--ferme")) {
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
            this.ajouterEcouteursEvements();
        }
        return MenuMobile;
    }());
    exports.MenuMobile = MenuMobile;
});
//# sourceMappingURL=menuMobile.js.map