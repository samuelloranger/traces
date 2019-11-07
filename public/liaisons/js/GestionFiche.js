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
            //Commentaire du livre
            this.formulaireNouveauCommentaire = document.querySelector(".formulaireNouveauCommentaire");
            this.elementsFormCommentaire = Array.apply(null, this.formulaireNouveauCommentaire.querySelectorAll(".elementFormCommentaire"));
            this.boutonEnvoyerCommentaire = this.formulaireNouveauCommentaire.querySelector(".boutonEnvoyerCommentaireScript");
            this.boutonEnvoyerCommentaireActive = false;
            this.etatElementsFormulaire = [];
            //Ajout au panier
            this.btnAjoutPanier = document.querySelector(".btnAjoutPanierScript");
            this.urlParams = new URLSearchParams(window.location.search);
            //Attributs de classe
            this.panier = null;
            /**
             * Fonction ajouterEcoutersEvenements
             * @description Ajoute les écouteurs d'evenements sur les bons elements
             */
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
                    // Bouton envoyer un commentaire
                    _this.boutonEnvoyerCommentaire.addEventListener("click", function () {
                        _this.envoyerCommentaire();
                    });
                    //Éléments des commentaires
                    _this.elementsFormCommentaire.forEach(function (element) {
                        if (element.type !== "hidden") {
                            _this.etatElementsFormulaire[element.id] = false;
                            element.addEventListener("change", function () {
                                _this.verifierElementCommentaire(element);
                            });
                            element.addEventListener("keyup", function () {
                                _this.verifierElementCommentaire(element);
                            });
                        }
                    });
                }
            };
            /**
             * Fonction changerQte
             * @description Fait une opération sur la quantité des livres à ajouter au panier
             * @param operation Définit l'peration devrait être faite sur la quantité des livres
             */
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
            /**
             * Fonction verifierQteEntree
             * @description Vérrifie si la quntité entrée est correcte
             */
            this.verifierQteEntree = function () {
                if (Number(_this.selecteurQte.value) > 10) {
                    _this.selecteurQte.value = "10";
                }
                if (_this.selecteurQte.value == "" || Number(_this.selecteurQte.value) == 0 || Number(_this.selecteurQte.value) < 0) {
                    _this.selecteurQte.value = "1";
                }
            };
            /**
             * Fonction ajoutPanier
             * @description Ajoute l'item au panier
             */
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
                    panier.montrerFenetreModale(isbn);
                });
            };
            /**
             * Fonction verifierElementCommentaire
             * @description Vérifie si le contenu entré dans le formulaire est correct
             * @param element Élément qui est testé
             */
            this.verifierElementCommentaire = function (element) {
                var erreur = false;
                switch (element.type) {
                    case "text":
                        erreur = element.value.length === 0 || element.value.length < 10 || element.value.length > 50;
                        break;
                    case "textarea":
                        erreur = element.value.length === 0 || element.value.length < 50 || element.value.length > 255;
                        break;
                    case "number":
                        erreur = element.value < 1 || element.value > 5;
                        break;
                    default:
                        break;
                }
                if (erreur) {
                    _this.erreurElementCommentaire(element, "afficher");
                }
                else {
                    _this.erreurElementCommentaire(element, "retirer");
                    _this.etatElementsFormulaire[element.id] = true;
                }
                _this.verifirerTousElementsCommentaire();
            };
            /**
             * Fonction verifierTousElementsCommentaire
             * @description Vérifie si tous les éléments du formulaire sont ok
             * S'il y en a un qui n'est pas ok, il n'active pas le bouton d'envoi
             */
            this.verifirerTousElementsCommentaire = function () {
                var tousChampsValides = true;
                _this.elementsFormCommentaire.forEach(function (element) {
                    if (_this.etatElementsFormulaire[element.id] === false) {
                        tousChampsValides = false;
                    }
                });
                if (tousChampsValides) {
                    _this.activerDesactiverBtnEnvoyer("activer");
                }
            };
            /**
             * Fonction erreurelementCommentaire
             * @description Affiche l'erreur sur l'élément qui n'est pas correct
             * @param element L'élément à faire une opération
             * @param action L'action à effectuer sur cet élément
             */
            this.erreurElementCommentaire = function (element, action) {
                action === "afficher" ? element.classList.add("elementFormCommentaire--erreur") : element.classList.remove("elementFormCommentaire--erreur");
            };
            /**
             * Fonction activerDesactiverBtnEnvoyer
             * @description Active ou désactive le bouton d'envoi
             * @param action Action à effectuer sur le bouton
             */
            this.activerDesactiverBtnEnvoyer = function (action) {
                action === "activer" ? _this.boutonEnvoyerCommentaire.removeAttribute("disabled") : _this.boutonEnvoyerCommentaire.setAttribute("disabled", "disabled");
                _this.boutonEnvoyerCommentaireActive = true;
            };
            /**
             * Fonction envoyerCommentaire
             * @description Envoie le commentaire au serveur et attend le retour
             */
            this.envoyerCommentaire = function () {
                var stringData = "";
                _this.elementsFormCommentaire.forEach(function (element) {
                    stringData += element.id + "=" + element.value + "&";
                });
                if (_this.boutonEnvoyerCommentaireActive) {
                    $.ajax({
                        url: "index.php?controleur=livre?action=ajouterCommentaire",
                        type: "POST",
                        data: stringData,
                        dataType: "html"
                    })
                        .done(function (data, textStatus, jqXHR) {
                        //fonction
                        console.log(data);
                    });
                }
            };
            this.panier = panier;
            this.ajouterEcouteursEvenements();
        }
        return GestionFiche;
    }());
    exports.GestionFiche = GestionFiche;
});
//# sourceMappingURL=GestionFiche.js.map