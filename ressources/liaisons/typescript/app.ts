import {CommentairesEtoiles} from "./CommentairesEtoiles";
import {Menu} from "./Menu";
import {GestionPanier} from "./GestionPanier";
import {GestionFiche} from "./GestionFiche";
import {GestionAccueil} from "./GestionAccueil";
import {GestionCatalogue} from "./GestionCatalogue";

document.querySelector("body").classList.add("js");

const commentairesEtoiles = new CommentairesEtoiles();
const menuMobile = new Menu();
const gestionPanier = new GestionPanier();
const gestionFiche = new GestionFiche(gestionPanier);
const gestionAccueil = new GestionAccueil(gestionPanier);
const gestionCatalogue = new GestionCatalogue(gestionPanier);
