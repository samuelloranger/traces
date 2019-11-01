define(["require", "exports", "./CommentairesEtoiles", "./Menu", "./GestionPanier", "./GestionFiche"], function (require, exports, CommentairesEtoiles_1, Menu_1, GestionPanier_1, GestionFiche_1) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var commentairesEtoiles = new CommentairesEtoiles_1.CommentairesEtoiles();
    var menuMobile = new Menu_1.Menu();
    var gestionPanier = new GestionPanier_1.GestionPanier();
    var gestionFiche = new GestionFiche_1.GestionFiche(gestionPanier);
    document.querySelector("body").classList.add("js");
});
//# sourceMappingURL=app.js.map