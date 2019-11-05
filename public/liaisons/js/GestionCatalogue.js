define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionCatalogue = /** @class */ (function () {
        function GestionCatalogue(panier) {
            var _this = this;
            //Ajout au panier
            this.btnsAjoutPanier = Array.apply(null, document.querySelectorAll(".catalogue__btn--ajouterPanierScript"));
            this.urlParams = new URLSearchParams(window.location.search);
            //Attributs de classe
            this.panier = null;
            this.ajouterEcouteursEvenements = function () {
                // Quantité : Bouton soustraire
                var controleur = _this.urlParams.get('controleur');
                var action = _this.urlParams.get('action');
                if (controleur === "livre" && action === "catalogue" || controleur === null && action === null) {
                    _this.btnsAjoutPanier.forEach(function (element) {
                        element.addEventListener("click", function () {
                            _this.ajoutPanier(element);
                        });
                    });
                }
            };
            this.ajoutPanier = function (element) {
                var isbnLivre = element.value;
                var panier = _this.panier;
                $.ajax({
                    url: "index.php?controleur=panier&action=ajoutPanier&redirection=aucune&isbn=" + isbnLivre,
                    type: "POST",
                    data: "&qte=1",
                    dataType: "html"
                })
                    .done(function (data, textStatus, jqXHR) {
                    panier.majItemPanierHeader(data, textStatus, jqXHR);
                    panier.montrerFenetreModale(isbnLivre);
                });
            };
            this.panier = panier;
            this.ajouterEcouteursEvenements();
        }
        return GestionCatalogue;
    }());
    exports.GestionCatalogue = GestionCatalogue;
});
//# sourceMappingURL=GestionCatalogue.js.map