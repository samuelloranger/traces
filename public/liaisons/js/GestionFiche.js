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
            this.zoneCommentaires = document.querySelector(".zoneCommentaires");
            this.formulaireNouveauCommentaire = document.querySelector(".formulaireNouveauCommentaire");
            this.elementsFormCommentaire = null;
            this.boutonEnvoyerCommentaire = null;
            this.boutonEnvoyerCommentaireActive = false;
            this.etatElementsFormulaire = [];
            //Ajout au panier
            this.btnAjoutPanier = document.querySelector(".btnAjoutPanierScript");
            this.urlParams = new URLSearchParams(window.location.search);
            //Attributs de classe
            this.panier = null;
            this.arrZoneEtoiles = null;
            this.messageErreurs = null;
            /**
             * Fonction ajouterEcoutersEvenements
             * @description Ajoute les écouteurs d'evenements sur les bons elements
             */
            this.ajouterEcouteursEvenements = function () {
                // Quantité : Bouton soustraire
                var controleur = _this.urlParams.get('controleur');
                var action = _this.urlParams.get('action');
                if (controleur === "livre" && action === "fiche") {
                    //Initialisation des étoiles
                    _this.initialiserEtoiles();
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
                    _this.elementsFormCommentaire = Array.apply(null, _this.formulaireNouveauCommentaire.querySelectorAll(".elementFormCommentaire"));
                    _this.boutonEnvoyerCommentaire = _this.formulaireNouveauCommentaire.querySelector(".boutonEnvoyerCommentaireScript");
                    // Bouton envoyer un commentaire
                    _this.boutonEnvoyerCommentaire.addEventListener("click", function () {
                        _this.envoyerCommentaire();
                    });
                    //Éléments des commentaires
                    _this.elementsFormCommentaire.forEach(function (element) {
                        if (element.type !== "hidden" && !element.classList.contains("elementFormCommentaire--nonObligatoire")) {
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
             * Fonction initialiserEtoiles
             * @description Initialisation des étoiles des commentaires
             */
            this.initialiserEtoiles = function () {
                _this.arrZoneEtoiles = Array.apply(null, document.querySelectorAll(".zoneEtoiles"));
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
                        elementEtoile.classList.add("etoile", "etoilePleine");
                        var elementSVG = document.createElement("img");
                        elementSVG.setAttribute("src", "./liaisons/images/icones/etoile-pleine.svg");
                        elementSVG.setAttribute("alt", "Étoile pleine");
                        elementEtoile.appendChild(elementSVG);
                        //On envoie l'element dans la zone d'etoiles
                        zoneEtoile.appendChild(elementEtoile);
                    }
                    for (var intCtr = 0; intCtr < 5 - nbrEtoilesPleines; intCtr++) {
                        //On creer l'element span, on lui insere une classe
                        var elementEtoile = document.createElement("span");
                        elementEtoile.classList.add("etoile", "etoileVite");
                        var elementSVG = document.createElement("img");
                        elementSVG.setAttribute("src", "./liaisons/images/icones/etoile-vide.svg");
                        elementSVG.setAttribute("alt", "Étoile pleine");
                        elementEtoile.appendChild(elementSVG);
                        //On envoie l'element dans la zone d'etoiles
                        zoneEtoile.appendChild(elementEtoile);
                    }
                });
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
                var erreur = true;
                var typeErreur = "";
                switch (element.type) {
                    case "text":
                        if (element.value.length === 0) {
                            typeErreur = "vide";
                        }
                        else if (element.value.length < 10) {
                            typeErreur = "court";
                        }
                        else if (element.value.length > 50) {
                            typeErreur = "long";
                        }
                        else {
                            erreur = false;
                        }
                        break;
                    case "textarea":
                        if (element.value.length === 0) {
                            typeErreur = "vide";
                        }
                        else if (element.value.length < element.minLength) {
                            typeErreur = "court";
                        }
                        else if (element.value.length > element.maxLength) {
                            typeErreur = "long";
                        }
                        else {
                            erreur = false;
                        }
                        _this.changerCaracteresRestants(element);
                        break;
                    case "number":
                        if (element.value < 0) {
                            typeErreur = "invalide";
                            element.value = 1;
                        }
                        else if (element.value < 1) {
                            typeErreur = "invalide";
                        }
                        else if (element.value > 5) {
                            typeErreur = "invalide";
                            element.value = 5;
                        }
                        else if (element.value.length == 0) {
                            typeErreur = "vide";
                        }
                        else {
                            erreur = false;
                        }
                        break;
                    default:
                        break;
                }
                if (erreur) {
                    _this.erreurElementCommentaire(element, "afficher", typeErreur);
                }
                else {
                    _this.erreurElementCommentaire(element, "retirer");
                    _this.etatElementsFormulaire[element.id] = true;
                }
                _this.verifirerTousElementsCommentaire();
            };
            this.changerCaracteresRestants = function (element) {
                var caracteresMax = element.maxLength;
                var zoneCarRestants = element.parentNode.querySelector(".caracteresRestants");
                zoneCarRestants.innerHTML = caracteresMax - element.value.length;
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
             * @param typeErreur Le type d'erreur envoyé - Valeur de base: "aucune"
             */
            this.erreurElementCommentaire = function (element, action, typeErreur) {
                if (typeErreur === void 0) { typeErreur = "aucune"; }
                var messageErreur = element.parentNode.querySelector(".erreur");
                if (action === "afficher") {
                    element.classList.add("elementFormCommentaire--erreur");
                    messageErreur.innerHTML = _this.messageErreurs[element.name][typeErreur];
                }
                else {
                    element.classList.remove("elementFormCommentaire--erreur");
                    messageErreur.innerHTML = "";
                }
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
                var fiche = _this;
                var stringData = "";
                _this.elementsFormCommentaire.forEach(function (element) {
                    stringData += element.id + "=" + element.value + "&";
                });
                stringData += "isAjax";
                if (_this.boutonEnvoyerCommentaireActive) {
                    $.ajax({
                        url: "index.php?controleur=livre&action=ajouterCommentaire",
                        type: "POST",
                        data: stringData,
                        dataType: "html"
                    })
                        .done(function (data, textStatus, jqXHR) {
                        //fonction
                        fiche.afficherCommentaires(data, textStatus, jqXHR);
                    });
                }
            };
            /**
             * Fonction afficherCommentaires
             * @param data Est le data qui est revenu du PHP (Qui normalement devrait être la zone des commentaires de la vue modifiée
             * @param textStatus
             * @param jqXHR
             */
            this.afficherCommentaires = function (data, textStatus, jqXHR) {
                _this.zoneCommentaires.innerHTML = data;
                _this.initialiserEtoiles();
            };
            this.panier = panier;
            this.ajouterEcouteursEvenements();
            fetch("../ressources/liaisons/typescript/messagesCommentaires.json")
                .then(function (response) {
                return response.json();
            })
                .then(function (response) {
                _this.messageErreurs = response;
            })
                .catch(function (error) {
                console.log(error);
            });
        }
        return GestionFiche;
    }());
    exports.GestionFiche = GestionFiche;
});
//# sourceMappingURL=GestionFiche.js.map