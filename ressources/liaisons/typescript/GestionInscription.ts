export class GestionInscription {
    private tChampsFormulaire:[HTMLInputElement] = Array.apply(null, document.querySelectorAll(".champ_formulaire"));
    private objValidation = {};


    private formulaireValide = true;
    private objEtatChamps = null;

    public constructor() {
        this.objEtatChamps = this.initialiserEtat();
        console.log(this.tChampsFormulaire);

        this.tChampsFormulaire.forEach(champ => {
           console.log(champ.pattern);
        });

        fetch("../ressources/liaisons/typescript/messagesInscription.json")
            .then(response => {
                return response.json();
            })
            .then(response => {
                this.objValidation = response;
                this.initialiser();
            })
            .catch(error => {
                console.log(error);
            })
    }

    private initialiser = () => {
        console.log(this.objValidation);
        this.tChampsFormulaire.forEach(champ => {
            champ.addEventListener("blur", this.validerChamp);
        });
        this.verifierFormulaire();
    };

    private validerChamp = (e) => {
        const champ = e.currentTarget;
        const valeur = champ.value;
        const pattern = new RegExp(champ.pattern);
        let champValide = pattern.test(valeur);

        //const conteneurParent = champ.closest("div");
        const paragrapheRetro = document.getElementById(`retro-${champ.name}`);

        console.log(champ.name);
        //console.log(conteneurParent.children);

        //console.log(champValide);
        if (champValide) {
            //conteneurParent.removeChild(paragrapheRetro);
            if (paragrapheRetro.innerHTML !== "") {
                paragrapheRetro.innerHTML = ""
            }

            this.objEtatChamps[champ.name].estValide = champValide;
            if (champ.classList.contains("champ_invalide")) {
                champ.classList.remove("champ_invalide");
            }
            champ.classList.add("champ_valide");
        } else if (!champValide) {

            //Si la retroaction n'existe pas
            if (paragrapheRetro.innerText === "") {
                paragrapheRetro.innerHTML = this.objValidation[champ.name].pattern;
            }

            this.objEtatChamps[champ.name].estValide = champValide;
            if (champ.classList.contains("champ_valide")) {
                champ.classList.remove("champ_valide");
            }
            champ.classList.add("champ_invalide");
        }
        this.verifierFormulaire();
    };

    private verifierFormulaire = () => {
        this.formulaireValide = this.objEtatChamps.prenom.estValide &&
            this.objEtatChamps.nom.estValide &&
            this.objEtatChamps.email.estValide &&
            this.objEtatChamps.tel.estValide &&
            this.objEtatChamps.mdp.estValide &&
            this.objEtatChamps.c_mdp.estValide;

        console.log("formulaire valide: ", this.formulaireValide)
    };


    private initialiserEtat = () => {
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
        }
    }
}