/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var CommentairesEtoiles = /** @class */ (function () {
        function CommentairesEtoiles() {
            var _this = this;
            this.arrZoneEtoiles = Array.apply(null, document.querySelectorAll(".zoneEtoiles"));
            this.initialiser = function () {
                //Pour chaque commentaire
                _this.arrZoneEtoiles.forEach(function (zoneEtoile) {
                    //On va chercher l'attribut class de l'élément
                    var classeNbr = zoneEtoile.getAttribute("class").split(" ");
                    //On retire le "zoneEtoile" de la classe pour garder seulement le nombre
                    var nbrEtoilesPleines = Number(classeNbr[1].replace("zoneEtoiles", ""));
                    //Si le nombre d'elements est plus élevé que 5, on fixe à 5
                    if (nbrEtoilesPleines > 5)
                        nbrEtoilesPleines = 5;
                    //On boucle nbrElements fois pour ajouter l'élément
                    for (var intCtr = 0; intCtr < nbrEtoilesPleines; intCtr++) {
                        //On creer l'element span, on lui insere une classe
                        var elementEtoile = document.createElement("span");
                        elementEtoile.classList.add("etoilePleine");
                        /** POUR DEV AVANT CSS */ elementEtoile.innerText = "Etoile pleine";
                        //On envoie l'element dans la zone d'etoiles
                        zoneEtoile.appendChild(elementEtoile);
                    }
                    for (var intCtr = 0; intCtr < 5 - nbrEtoilesPleines; intCtr++) {
                        //On creer l'element span, on lui insere une classe
                        var elementEtoile = document.createElement("span");
                        elementEtoile.classList.add("etoileVite");
                        /** POUR DEV AVANT CSS */ elementEtoile.innerText = "Etoile vide";
                        //On envoie l'element dans la zone d'etoiles
                        zoneEtoile.appendChild(elementEtoile);
                    }
                });
            };
            this.initialiser();
        }
        return CommentairesEtoiles;
    }());
    exports.CommentairesEtoiles = CommentairesEtoiles;
});
//# sourceMappingURL=CommentairesEtoiles.js.map