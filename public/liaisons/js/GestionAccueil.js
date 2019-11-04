define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionAccueil = /** @class */ (function () {
        function GestionAccueil(panier) {
            var _this = this;
            //Ajout au panier
            this.btnsAjoutPanier = Array.apply(null, document.querySelectorAll(".bouton_panierScript"));
            this.urlParams = new URLSearchParams(window.location.search);
            //Attributs de classe
            this.panier = null;
            this.ajouterEcouteursEvenements = function () {
                // Quantité : Bouton soustraire
                var controleur = _this.urlParams.get('controleur');
                var action = _this.urlParams.get('action');
                if (controleur === "site" && action === "accueil" || controleur === null && action === null) {
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
                });
            };
            this.panier = panier;
            this.ajouterEcouteursEvenements();
        }
        return GestionAccueil;
    }());
    exports.GestionAccueil = GestionAccueil;
});
//# sourceMappingURL=GestionAccueil.js.map