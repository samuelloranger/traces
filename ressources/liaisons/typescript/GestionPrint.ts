export class GestionPrint {
    private urlParams = new URLSearchParams(window.location.search);

    public constructor() {
        const controleur = this.urlParams.get("controleur");
        const action = this.urlParams.get("action");

        if (controleur === "validation" && action === "confirmation") {
            const bouton = document.getElementById("impression_commande");
            bouton.addEventListener("click", () => {
                window.print();
            });
        }
    }
}