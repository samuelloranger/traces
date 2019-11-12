export class GestionConnexion {
    //Gestion de l'url
    private urlParams = new URLSearchParams(window.location.search);

    //Gestion d'etat
    private objValidation = {};
    private formulaireValide = true;
    private objEtatChamps = null;

    //Gestion d'elements DOM
    private tChampsFormulaire = null;
    private togglePassword = null;

    public constructor() {
        this.objEtatChamps = this.initialiserEtat();

        fetch("../ressources/liaisons/typescript/messagesConnexion.json")
            .then(response => {
                return response.json();
            })
            .then(response => {
                this.objValidation = response;
                this.initialiser();
            })
            .catch(error => {
                console.log(error);
            });
    }

    public initialiser = () => {
        const controleur = this.urlParams.get("controleur");
        const action = this.urlParams.get("action");

        if (controleur === "compte" && action === "connexion") {
            this.tChampsFormulaire = Array.apply(null, document.querySelectorAll(".js_connexion"));
            this.togglePassword = document.querySelector(".toggle");
            console.log(this.tChampsFormulaire);

            this.tChampsFormulaire.forEach(champ => {
                champ.addEventListener("blur", this.validerChamp);
            });
            this.togglePassword.addEventListener("change", this.toggleMotPasse);
            this.verifierFormulaire();
        }

    };

    private validerChamp = (e) => {
        console.log(e.currentTarget);

        const champ = e.currentTarget;
        const valeur = champ.value;
        const pattern = new RegExp(champ.pattern);
        const paragrapheRetro = document.getElementById(`retro-${champ.name}`);
        let champValide = pattern.test(valeur);

        if (champValide) {
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
        this.formulaireValide = this.objEtatChamps.email.estValide && this.objEtatChamps.mdp.estValide;

        if (!this.formulaireValide) {
            document.getElementById("connecter").setAttribute("disabled", "disabled");
        } else {
            document.getElementById("connecter").removeAttribute("disabled");
        }
    };

    private toggleMotPasse = (e) => {
        const checkbox = e.currentTarget;
        const inputPassword = document.querySelector("[name='mdp']");
        //console.log(inputPassword);
        //console.log(checkbox.checked);

        if (checkbox.checked) {
            inputPassword.setAttribute("type", "text");
        } else {
            inputPassword.setAttribute("type", "password");
        }
    };

    private verifierMotPasse = (mdp: string) => {

    };

    private initialiserEtat = (): object => {
        return {
            "email": {
                "estValide": false,
            },
            "mdp": {
                "estValide": false,
            },
        }
    };
}