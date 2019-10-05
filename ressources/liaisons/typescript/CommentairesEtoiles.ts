/**
 * @author Samuel Loranger <samuelloranger@gmail.com>
 */

export class CommentairesEtoiles {
    private arrZoneEtoiles:HTMLElement[] = Array.apply(null, document.querySelectorAll(".zoneEtoiles"));

    constructor(){
        this.initialiser();
    }

    private initialiser = () => {
        //Pour chaque commentaire
        this.arrZoneEtoiles.forEach((zoneEtoile) => {
            //On va chercher l'attribut class de l'élément
            let classeNbr = zoneEtoile.getAttribute("class").split(" ");

            //On retire le "zoneEtoile" de la classe pour garder seulement le nombre
            let nbrEtoilesPleines = Number(classeNbr[1].replace("zoneEtoiles", ""));

            //Si le nombre d'elements est plus élevé que 5, on fixe à 5
            if(nbrEtoilesPleines > 5) nbrEtoilesPleines = 5;

            //On boucle nbrElements fois pour ajouter l'élément
            for(let intCtr = 0; intCtr < nbrEtoilesPleines; intCtr++){
                //On creer l'element span, on lui insere une classe
                const elementEtoile:HTMLElement = document.createElement("span");
                elementEtoile.classList.add("etoilePleine");

                /** POUR DEV AVANT CSS */elementEtoile.innerText = "Etoile pleine";

                //On envoie l'element dans la zone d'etoiles
                zoneEtoile.appendChild(elementEtoile);
            }

            for(let intCtr = 0; intCtr < 5 - nbrEtoilesPleines; intCtr++){
                //On creer l'element span, on lui insere une classe
                const elementEtoile:HTMLElement = document.createElement("span");
                elementEtoile.classList.add("etoileVite");

                /** POUR DEV AVANT CSS */elementEtoile.innerText = "Etoile vide";

                //On envoie l'element dans la zone d'etoiles
                zoneEtoile.appendChild(elementEtoile);
            }
        });
    };
}