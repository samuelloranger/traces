<div class="confirmation">
    <div class="transaction">
        <h1 class="transaction__titre">Confirmation</h1>
        <div class="transaction__centrer">
            <div class="transation__messageGeneral">
                <span class="icone__validation"></span>
                <h2 class="transaction__sous-titre">Nous avons bien reçu votre commande.</h2>
            </div>
            <p class="confirmation__espacement">Elle vous sera expédiée selon les modalitées que vous avez choisies. N'hésitez pas à consulter notre service à la clientèle pour plus d'informations relatives à votre commande ou votre compte.</p>
            <p><b>Votre numéro de confirmation est le:</b></p>
            <p><b>XXXXXXXXXXXXX</b></p>
            <p>Vous recevrez d'ici quelques minutes une confirmation de votre commande par courriel.</p>
        </div>

        <div class="transaction__background confirmation__resumeCommande">
            <div class="confirmation__resumeCommande__zoneInfo">
                <h3 class="transaction__sous-titre">Sommaire de votre commande</h3>
                <div class="infoPanierFlex text-right confirmation__espacement">
                    <p>3 items</p>
                    <p>CAD 68,95$</p>
                </div>
                <div class="infoPanierFlex text-right">
                    <p>TPS 5%</p>
                    <p>CAD 4,45$</p>
                </div>
                <div class="infoPanierFlex text-right">
                    <p>Livraison standard</p>
                    <p>CAD 4,45$</p>
                </div>
                <div class="infoPanierFlex text-right">
                    <p>Total</p>
                    <p>CAD 4,45$</p>
                </div>
            </div>

            <div class="confirmation__resumeCommande__zoneInfo">
                <h3 class="transaction__sous-titre">Adresse de livraison</h3>
                <p class="confirmation__espacement">Prénom nom</p>
                <p>133 Rue Sieur Nicol</p>
                <p>Québec</p>
                <p>QC</p>
                <p>G1G 1G1</p>
            </div>

            <div class="confirmation__resumeCommande__zoneInfo">
                <h3 class="transaction__sous-titre">Adresse de facturation</h3>
                <p class="confirmation__espacement">Prénom nom</p>
                <p>133 Rue Sieur Nicol</p>
                <p>Québec</p>
                <p>QC</p>
                <p>G1G 1G1</p>
            </div>

            <div class="confirmation__resumeCommande__zoneInfo">
                <h3 class="transaction__sous-titre">Mode de paiement</h3>
                <p class="confirmation__espacement">Nom prénom</p>

                <div class="mode-paiement">
                    {{--        Ici tu envoie le mode de paiement sélectionné, tu pourras changer la source de l'image ensuite        --}}
{{--                    <img class="logo" src="liaisons/images/transaction/visa.svg" alt="visa">--}}
                    {{--                <img class="logo" src="liaisons/images/transaction/mastercard.svg" alt="Mastercard">--}}
                    {{--                <img class="logo" src="liaisons/images/transaction/american-express.svg" alt="AMEX">--}}
                    <p class="numeroCarte">XXXX XXXX XXXX 1234</p>
                </div>
            </div>

            <div class="transaction__resumePanier zone">
                <h3 class="transaction__sous-titre">Informations</h3>
                <p class="confirmation__espacement">samuelloranger@gmail.com</p>
                <p>581-748-0646</p>
            </div>
        </div>

        <div class="confirmation__resumeItems">
            {{--      LA BOUCLE D'AFFICHAGE VA ÊTRE ICI      --}}
            <div class="confirmation__resumeItems__item">
                <div class="conteneurItem">
{{--                    <img class="couvertureLivre" src="liaisons/images/couvertures-livres/L97828944851871_carre.jpg">--}}
                    <div class="titreAuteur">
                        <h4>Les chroniques d'une mère indigne</h4>
                        <p>Caroline Allard</p>
                    </div>

                    <div class="prixItem">
                        <p>Total (2):</p>
                        <p>18.95$</p>
                    </div>
                </div>
            </div>

            <div class="confirmation__resumeItems__item">
                <div class="conteneurItem">
{{--                    <img class="couvertureLivre" src="liaisons/images/couvertures-livres/L97828944851871_carre.jpg">--}}
                    <div class="titreAuteur">
                        <h4>Les chroniques d'une mère indigne</h4>
                        <p>Caroline Allard</p>
                    </div>

                    <div class="prixItem">
                        <p>Total (2):</p>
                        <p>18.95$</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>