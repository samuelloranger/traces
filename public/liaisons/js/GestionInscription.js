// interface IEtatChamps {
//     [key: string]: {
//         estValide: boolean;
//     }
// }
define(["require", "exports"], function (require, exports) {
    "use strict";
    Object.defineProperty(exports, "__esModule", { value: true });
    var GestionInscription = /** @class */ (function () {
        function GestionInscription() {
            var _this = this;
            this.tChampsFormulaire = Array.apply(null, document.querySelectorAll(".champ_formulaire"));
            this.objValidation = {};
            this.formulaireValide = true;
            this.objEtatChamps = null;
            this.initialiser = function () {
                console.log(_this.objValidation);
                _this.tChampsFormulaire.forEach(function (champ) {
                    champ.addEventListener("blur", _this.validerChamp);
                });
                _this.verifierFormulaire();
            };
            this.validerChamp = function (e) {
                var champ = e.currentTarget;
                var valeur = champ.value;
                var pattern = new RegExp(champ.pattern);
                var champValide = pattern.test(valeur);
                //const conteneurParent = champ.closest("div");
                var paragrapheRetro = document.getElementById("retro-" + champ.name);
                console.log(champ.name);
                //console.log(conteneurParent.children);
                //console.log(champValide);
                if (champValide) {
                    //conteneurParent.removeChild(paragrapheRetro);
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
                _this.formulaireValide = _this.objEtatChamps.prenom.estValide &&
                    _this.objEtatChamps.nom.estValide &&
                    _this.objEtatChamps.email.estValide &&
                    _this.objEtatChamps.tel.estValide &&
                    _this.objEtatChamps.mdp.estValide &&
                    _this.objEtatChamps.c_mdp.estValide;
                console.log("formulaire valide: ", _this.formulaireValide);
            };
            this.initialiserEtat = function () {
                return {
                    "prenom": {
                        "estValide": false,
                    },
                    "nom": {
                        "estValide": false,
                    },
                    "email": {
                        "estValide": false,
                    },
                    "tel": {
                        "estValide": false,
                    },
                    "mdp": {
                        "estValide": false,
                    },
                    "c_mdp": {
                        "estValide": false,
                    },
                };
            };
            this.objEtatChamps = this.initialiserEtat();
            console.log(this.tChampsFormulaire);
            this.tChampsFormulaire.forEach(function (champ) {
                console.log(champ.pattern);
            });
            fetch("../ressources/liaisons/typescript/messagesInscription.json")
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
        return GestionInscription;
    }());
    exports.GestionInscription = GestionInscription;
});
//# sourceMappingURL=GestionInscription.js.map