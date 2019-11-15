define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionPrint = /** @class */ (function () {
        function GestionPrint() {
            this.urlParams = new URLSearchParams(window.location.search);
            var controleur = this.urlParams.get("controleur");
            var action = this.urlParams.get("action");
            if (controleur === "validation" && action === "confirmation") {
                var bouton = document.getElementById("impression_commande");
                bouton.addEventListener("click", function () {
                    window.print();
                });
            }
        }
        return GestionPrint;
    }());
    exports.GestionPrint = GestionPrint;
});
//# sourceMappingURL=GestionPrint.js.map