define(["require", "exports", "./CommentairesEtoiles", "./Menu", "./GestionPanier", "./GestionFiche", "./GestionAccueil", "./GestionCatalogue", "./GestionInscription"], function (require, exports, CommentairesEtoiles_1, Menu_1, GestionPanier_1, GestionFiche_1, GestionAccueil_1, GestionCatalogue_1, GestionInscription_1) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    document.querySelector("body").classList.add("js");
    var commentairesEtoiles = new CommentairesEtoiles_1.CommentairesEtoiles();
    var menuMobile = new Menu_1.Menu();
    var gestionPanier = new GestionPanier_1.GestionPanier();
    var gestionFiche = new GestionFiche_1.GestionFiche(gestionPanier, commentairesEtoiles);
    var gestionAccueil = new GestionAccueil_1.GestionAccueil(gestionPanier);
    var gestionCatalogue = new GestionCatalogue_1.GestionCatalogue(gestionPanier);
    var gestionInscription = new GestionInscription_1.GestionInscription();
});
//# sourceMappingURL=app.js.map