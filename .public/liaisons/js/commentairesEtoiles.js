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
                var elementEtoiles = document.createElement("<span class='etoile'>Test</span>");
                _this.arrZoneEtoiles.forEach(function (zoneEtoile) {
                    var classeNbr = zoneEtoile.getAttribute("class");
                    console.log(classeNbr);
                });
            };
            this.initialiser();
        }
        return CommentairesEtoiles;
    }());
    exports.CommentairesEtoiles = CommentairesEtoiles;
});
//# sourceMappingURL=commentairesEtoiles.js.map