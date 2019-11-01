/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */

export class GestionFiche {
    private btnSoustraire:HTMLElement = document.querySelector(".btnChangementQte__soustraire");
    private btnAjouter:HTMLElement = document.querySelector(".btnChangementQte__additionner");
    private selecteurQte:HTMLInputElement = document.querySelector(".qteCourante");

    constructor(){
        this.ajouterEcouteursEvenements();
    }


    private ajouterEcouteursEvenements = () => {
        this.btnSoustraire.addEventListener = () => {
            this.changerQte("soustraire");
            console.log("");
        };

        this.btnAjouter.addEventListener = () => {
            this.changerQte("additionner");
        };
    };

    private changerQte = (operation) => {
        switch(operation){
            case "soustraire":
                if(Number(this.selecteurQte.value) != 1){
                    this.selecteurQte.value = String(Number(this.selecteurQte.value) - 1);
                }
                break;
            case "additionner":
                if(Number(this.selecteurQte.value) != 10){
                    this.selecteurQte.value = String(Number(this.selecteurQte.value) + 1);
                }
                break;
            default:
                break;
        }
    };

}