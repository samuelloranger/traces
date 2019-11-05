define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionFiche = /** @class */ (function () {
        function GestionFiche(panier) {
            var _this = this;
            //Sélecteurs de quantité
            this.btnSoustraire = document.querySelector(".btnChangementQte__soustraire");
            this.btnAjouter = document.querySelector(".btnChangementQte__additionner");
            this.selecteurQte = document.querySelector(".qteCourante");
            //Ajout au panier
            this.btnAjoutPanier = document.querySelector(".btnAjoutPanierScript");
            this.urlParams = new URLSearchParams(window.location.search);
            //Attributs de classe
            this.panier = null;
            this.ajouterEcouteursEvenements = function () {
                // Quantité : Bouton soustraire
                var controleur = _this.urlParams.get('controleur');
                var action = _this.urlParams.get('action');
                if (controleur === "livre" && action === "fiche") {
                    _this.btnSoustraire.addEventListener("click", function () {
                        _this.changerQte("soustraire");
                    });
                    // Quantité : Bouton additionner
                    _this.btnAjouter.addEventListener("click", function () {
                        _this.changerQte("additionner");
                    });
                    // Quantité : Selecteur de quantité
                    _this.selecteurQte.addEventListener("change", function () {
                        _this.verifierQteEntree();
                    });
                    // Quantité : Bouton soustraire
                    _this.btnAjoutPanier.addEventListener("click", function () {
                        _this.ajoutPanier();
                    });
                }
            };
            this.changerQte = function (operation) {
                switch (operation) {
                    case "soustraire":
                        if (Number(_this.selecteurQte.value) > 1) {
                            _this.selecteurQte.value = String(Number(_this.selecteurQte.value) - 1);
                        }
                        break;
                    case "additionner":
                        if (Number(_this.selecteurQte.value) < 10) {
                            _this.selecteurQte.value = String(Number(_this.selecteurQte.value) + 1);
                        }
                        break;
                    default:
                        break;
                }
            };
            this.verifierQteEntree = function () {
                if (Number(_this.selecteurQte.value) > 10) {
                    _this.selecteurQte.value = "10";
                }
                if (_this.selecteurQte.value == "" || Number(_this.selecteurQte.value) == 0 || Number(_this.selecteurQte.value) < 0) {
                    _this.selecteurQte.value = "1";
                }
            };
            this.ajoutPanier = function () {
                var isbn = _this.urlParams.get('isbn');
                var panier = _this.panier;
                $.ajax({
                    url: "index.php?controleur=panier&action=ajoutPanier&redirection=aucune&isbn=" + isbn,
                    type: "POST",
                    data: "&qte=" + _this.selecteurQte.value,
                    dataType: "html"
                })
                    .done(function (data, textStatus, jqXHR) {
                    panier.majItemPanierHeader(data, textStatus, jqXHR);
                });
                panier.montrerFenetreModale(isbn);
            };
            this.panier = panier;
            this.ajouterEcouteursEvenements();
        }
        return GestionFiche;
    }());
    exports.GestionFiche = GestionFiche;
});
//# sourceMappingURL=GestionFiche.js.map