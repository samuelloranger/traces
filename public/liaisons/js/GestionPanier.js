/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionPanier = /** @class */ (function () {
        function GestionPanier() {
            var _this = this;
            this.selecteurFraisLivraison = document.querySelector("#fraisLivraisonSelect");
            this.iconePanier = document.querySelector(".iconePanier");
            this.nbrItemsPanier = Array.apply(null, document.querySelectorAll(".nbrItemsPanier"));
            this.arrBtnSupprimer = null;
            this.urlParams = new URLSearchParams(window.location.search);
            this.initialiser = function () {
                _this.ajouterEcouteursEvenements();
            };
            this.ajouterEcouteursEvenements = function () {
                _this.arrBtnSupprimer = Array.apply(null, document.querySelectorAll(".lienSupprItemScript"));
                var controleur = _this.urlParams.get('controleur');
                var action = _this.urlParams.get('action');
                if (controleur === "panier" && action === "panier") {
                    _this.arrBtnSupprimer.forEach(function (element) {
                        element.addEventListener("click", function () {
                            _this.supprimerItemPanier(element.value);
                        });
                    });
                }
            };
            this.majPanier = function (data, textStatus, jqXHR) {
                var site = document.querySelector("body");
                site.innerHTML = data;
                _this.ajouterEcouteursEvenements();
            };
            this.initialiser();
        }
        /**
         * Mets à jour le nombre d'items dans le panier dans le header du site
         * @param data
         * @param textStatus
         * @param jqXHR
         */
        GestionPanier.prototype.majItemPanierHeader = function (data, textStatus, jqXHR) {
            var _this = this;
            //On parse le retour de data en json
            //On va chercher la quantité retournée par le call Ajax
            var nbrItems = data;
            this.nbrItemsPanier.forEach(function (element) {
                if (element == null) {
                    var elementHTMLNbrItems = document.createElement("span");
                    var valeurNbrItems = document.createTextNode(nbrItems);
                    elementHTMLNbrItems.classList.add("nbrItemsPanier");
                    elementHTMLNbrItems.appendChild(valeurNbrItems);
                    _this.iconePanier.append(elementHTMLNbrItems);
                    _this.nbrItemsPanier.push(document.querySelector(".nbrItemsPanier"));
                }
                else {
                    element.innerHTML = nbrItems;
                }
            });
        };
        GestionPanier.prototype.supprimerItemPanier = function (isbnLivre) {
            var panier = this;
            $.ajax({
                url: "index.php?controleur=panier&action=supprimerItem&isbn=" + isbnLivre,
                type: "POST",
                data: "ajaxCall=ajaxCall",
                dataType: "html"
            })
                .done(function (data, textStatus, jqXHR) {
                panier.majPanier(data, textStatus, jqXHR);
            });
        };
        return GestionPanier;
    }());
    exports.GestionPanier = GestionPanier;
});
//# sourceMappingURL=GestionPanier.js.map