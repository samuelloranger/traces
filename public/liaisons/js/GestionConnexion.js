define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionConnexion = /** @class */ (function () {
        function GestionConnexion() {
            var _this = this;
            //Gestion de l'url
            this.urlParams = new URLSearchParams(window.location.search);
            //Gestion d'etat
            this.objValidation = {};
            this.formulaireValide = true;
            this.objEtatChamps = null;
            //Gestion d'elements DOM
            this.tChampsFormulaire = null;
            this.togglePassword = null;
            this.initialiser = function () {
                var controleur = _this.urlParams.get("controleur");
                var action = _this.urlParams.get("action");
                if (controleur === "compte" && action === "connexion") {
                    _this.tChampsFormulaire = Array.apply(null, document.querySelectorAll(".js_connexion"));
                    _this.togglePassword = document.querySelector(".toggle");
                    console.log(_this.tChampsFormulaire);
                    _this.tChampsFormulaire.forEach(function (champ) {
                        champ.addEventListener("blur", _this.validerChamp);
                    });
                    _this.togglePassword.addEventListener("change", _this.toggleMotPasse);
                    _this.verifierFormulaire();
                }
            };
            this.validerChamp = function (e) {
                console.log(e.currentTarget);
                var champ = e.currentTarget;
                var valeur = champ.value;
                var pattern = new RegExp(champ.pattern);
                var paragrapheRetro = document.getElementById("retro-" + champ.name);
                var champValide = pattern.test(valeur);
                if (champValide) {
                    if (paragrapheRetro.innerHTML !== "") {
                        paragrapheRetro.innerHTML = "";
                    }
                    _this.objEtatChamps[champ.name].estValide = champValide;
                    if (champ.classList.contains("champ_invalide")) {
                        champ.classList.remove("champ_invalide");
                    }
                    champ.classList.add("champ_valide");
                }
                else if (!champValide) {
                    //Si la retroaction n'existe pas
                    if (paragrapheRetro.innerText === "") {
                        paragrapheRetro.innerHTML = _this.objValidation[champ.name].pattern;
                    }
                    _this.objEtatChamps[champ.name].estValide = champValide;
                    if (champ.classList.contains("champ_valide")) {
                        champ.classList.remove("champ_valide");
                    }
                    champ.classList.add("champ_invalide");
                }
                _this.verifierFormulaire();
            };
            this.verifierFormulaire = function () {
                _this.formulaireValide = _this.objEtatChamps.email.estValide && _this.objEtatChamps.mdp.estValide;
                if (!_this.formulaireValide) {
                    document.getElementById("connecter").setAttribute("disabled", "disabled");
                }
                else {
                    document.getElementById("connecter").removeAttribute("disabled");
                }
            };
            this.toggleMotPasse = function (e) {
                var checkbox = e.currentTarget;
                var inputPassword = document.querySelector("[name='mdp']");
                //console.log(inputPassword);
                //console.log(checkbox.checked);
                if (checkbox.checked) {
                    inputPassword.setAttribute("type", "text");
                }
                else {
                    inputPassword.setAttribute("type", "password");
                }
            };
            this.verifierMotPasse = function (mdp) {
            };
            this.initialiserEtat = function () {
                return {
                    "email": {
                        "estValide": false,
                    },
                    "mdp": {
                        "estValide": false,
                    },
                };
            };
            this.objEtatChamps = this.initialiserEtat();
            fetch("../ressources/liaisons/typescript/messagesConnexion.json")
                .then(function (response) {
                return response.json();
            })
                .then(function (response) {
                _this.objValidation = response;
                _this.initialiser();
            })
                .catch(function (error) {
                console.log(error);
            });
        }
        return GestionConnexion;
    }());
    exports.GestionConnexion = GestionConnexion;
});
//# sourceMappingURL=GestionConnexion.js.map