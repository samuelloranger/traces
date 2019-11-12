define(["require", "exports", "./Menu", "./GestionPanier", "./GestionFiche", "./GestionAccueil", "./GestionCatalogue", "./GestionInscription", "./GestionConnexion"], function (require, exports, Menu_1, GestionPanier_1, GestionFiche_1, GestionAccueil_1, GestionCatalogue_1, GestionInscription_1, GestionConnexion_1) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    document.querySelector("body").classList.add("js");
    var menuMobile = new Menu_1.Menu();
    var gestionPanier = new GestionPanier_1.GestionPanier();
    var gestionFiche = new GestionFiche_1.GestionFiche(gestionPanier);
    var gestionAccueil = new GestionAccueil_1.GestionAccueil(gestionPanier);
    var gestionCatalogue = new GestionCatalogue_1.GestionCatalogue(gestionPanier);
    var gestionInscription = new GestionInscription_1.GestionInscription();
    var gestionConnexion = new GestionConnexion_1.GestionConnexion();
});
//# sourceMappingURL=app.js.map