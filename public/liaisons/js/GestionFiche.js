/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionFiche = /** @class */ (function () {
        function GestionFiche() {
            var _this = this;
            this.btnSoustraire = document.querySelector(".btnChangementQte__soustraire");
            this.btnAjouter = document.querySelector(".btnChangementQte__additionner");
            this.selecteurQte = document.querySelector(".qteCourante");
            this.ajouterEcouteursEvenements = function () {
                _this.btnSoustraire.addEventListener = function () {
                    _this.changerQte("soustraire");
                };
                _this.btnAjouter.addEventListener = function () {
                    _this.changerQte("additionner");
                };
            };
            this.changerQte = function (operation) {
                switch (operation) {
                    case "soustraire":
                        if (Number(_this.selecteurQte.value) != 1) {
                            _this.selecteurQte.value = String(Number(_this.selecteurQte.value) - 1);
                        }
                        break;
                    case "additionner":
                        if (Number(_this.selecteurQte.value) != 10) {
                            _this.selecteurQte.value = String(Number(_this.selecteurQte.value) + 1);
                        }
                        break;
                    default:
                        break;
                }
            };
            this.ajouterEcouteursEvenements();
        }
        return GestionFiche;
    }());
    exports.GestionFiche = GestionFiche;
});
//# sourceMappingURL=GestionFiche.js.map