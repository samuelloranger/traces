/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionPanier = /** @class */ (function () {
        function GestionPanier() {
            var _this = this;
            //Éléments définis une seule fois
            this.urlParams = new URLSearchParams(window.location.search);
            this.selecteurFraisLivraison = document.querySelector("#fraisLivraisonSelect");
            this.iconesPanier = Array.apply(null, document.querySelectorAll(".iconePanier"));
            //Éléments redéfinis
            this.nbrsItemsPanier = Array.apply(null, document.querySelectorAll(".nbrItemsPanier"));
            this.selecteursQteLivre = Array.apply(null, document.querySelectorAll(".qteItem"));
            this.arrBtnSupprimer = Array.apply(null, document.querySelectorAll(".lienSupprItemScript"));
            this.ajouterEcouteursEvenements = function () {
                _this.arrBtnSupprimer = Array.apply(null, document.querySelectorAll(".lienSupprItemScript"));
                _this.nbrsItemsPanier = Array.apply(null, document.querySelectorAll(".nbrItemsPanier"));
                _this.selecteursQteLivre = Array.apply(null, document.querySelectorAll(".qteItem"));
                var controleur = _this.urlParams.get('controleur');
                var action = _this.urlParams.get('action');
                //Si on est presentement dans le panier
                if (controleur === "panier" && action === "panier") {
                    _this.arrBtnSupprimer.forEach(function (element) {
                        element.addEventListener("click", function () {
                            _this.supprimerItemPanier(element.value);
                        });
                    });
                    _this.selecteursQteLivre.forEach(function (element) {
                        element.addEventListener("change", function () {
                            _this.majQteItem(element, Number(element.value));
                        });
                    });
                }
            };
            /**
             * Mets à jour le nombre d'items dans le panier dans le header du site
             * @param data
             * @param textStatus
             * @param jqXHR
             */
            this.majItemPanierHeader = function (data, textStatus, jqXHR) {
                //On parse le retour de data en json
                //On va chercher la quantité retournée par le call Ajax
                var nbrItems = data;
                _this.iconesPanier.forEach(function (element) {
                    if (element.querySelector(".nbrItemsPanier") == null) {
                        var elementHTMLNbrItems = document.createElement("span");
                        var valeurNbrItems = document.createTextNode(nbrItems);
                        elementHTMLNbrItems.classList.add("nbrItemsPanier");
                        elementHTMLNbrItems.appendChild(valeurNbrItems);
                        element.appendChild(elementHTMLNbrItems);
                        _this.nbrsItemsPanier.push(document.querySelector(".nbrItemsPanier"));
                    }
                    else {
                        _this.nbrsItemsPanier.forEach(function (element) {
                            element.innerHTML = nbrItems;
                        });
                    }
                });
            };
            this.majPanier = function (data, textStatus, jqXHR) {
                document.querySelector("main").innerHTML = data;
                _this.ajouterEcouteursEvenements();
                var panier = _this;
                $.ajax({
                    url: "index.php?controleur=panier&action=nbrItemsPanier",
                    type: "POST",
                    data: "isAjax",
                    dataType: "html"
                })
                    .done(function (data, textStatus, jqXHR) {
                    panier.majItemPanierHeader(data, textStatus, jqXHR);
                });
            };
            this.supprimerItemPanier = function (isbnLivre) {
                var panier = _this;
                $.ajax({
                    url: "index.php?controleur=panier&action=supprimerItem&isbn=" + isbnLivre,
                    type: "POST",
                    data: "isAjax",
                    dataType: "html"
                })
                    .done(function (data, textStatus, jqXHR) {
                    panier.majPanier(data, textStatus, jqXHR);
                });
            };
            this.majQteItem = function (element, qte) {
                var panier = _this;
                var isbnLivre = element.parentElement.parentElement.parentElement.querySelector(".isbn");
                $.ajax({
                    url: "index.php?controleur=panier&action=updateItem",
                    type: "POST",
                    data: "isbn=" + isbnLivre.value + "&qte=" + qte + "&isAjax=true",
                    dataType: "html"
                })
                    .done(function (data, textStatus, jqXHR) {
                    panier.majPanier(data, textStatus, jqXHR);
                });
            };
            this.ajouterEcouteursEvenements();
        }
        return GestionPanier;
    }());
    exports.GestionPanier = GestionPanier;
});
//# sourceMappingURL=GestionPanier.js.map