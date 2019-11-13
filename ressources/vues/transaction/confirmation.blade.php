@extends('transaction.gabarit')

@section('contenu')
    <div class="confirmation">
        <h1 class="transaction__titre">Confirmation</h1>
        <div class="transaction__centrer">
            <div class="transation__messageGeneral">
                <span class="icone__validation"></span>
                <h2>Nous avons bien reçu votre commande.</h2>
            </div>
            <p>Elle vous sera expédiée selon les modalitées que vous avez choisies. N'hésitez pas à consulter notre service à la clientèle pour plus d'informations relatives à votre commande ou votre compte.</p>
            <p><b>Votre numéro de confirmation est le:</b></p>
            <p><b>XXXXXXXXXXXXX</b></p>
            <p>Vous recevrez d'ici quelques minutes une confirmation de votre commande par courriel.</p>
        </div>

        <div class="transaction__background confirmation__resumeCommande">
            <div class="confirmation__resumeCommande__zoneInfo">
                <h3>Sommaire de votre commande</h3>
                <div class="infoPanierFlex text-right">
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
                <h3>Adresse de livraison</h3>
                <p>Prénom nom</p>
                <p>133 Rue Sieur Nicol</p>
                <p>Québec</p>
                <p>QC</p>
                <p>G1G 1G1</p>
            </div>

            <div class="confirmation__resumeCommande__zoneInfo">
                <h3>Adresse de facturation</h3>
                <p>Prénom nom</p>
                <p>133 Rue Sieur Nicol</p>
                <p>Québec</p>
                <p>QC</p>
                <p>G1G 1G1</p>
            </div>

            <div class="confirmation__resumeCommande__zoneInfo">
                <h3>Mode de paiement</h3>
                <p>Nom prénom</p>

                <div class="mode-paiement">
                    {{--        Ici tu envoie le mode de paiement sélectionné, tu pourras changer la source de l'image ensuite        --}}
                    <img class="logo" src="liaisons/images/transaction/visa.svg" alt="visa">
                    {{--                <img class="logo" src="liaisons/images/transaction/mastercard.svg" alt="Mastercard">--}}
                    {{--                <img class="logo" src="liaisons/images/transaction/american-express.svg" alt="AMEX">--}}
                    <p class="numeroCarte">XXXX XXXX XXXX 1234</p>
                </div>
            </div>

            <div class="transaction__resumePanier zone">
                <h3>Informations</h3>
                <p>samuelloranger@gmail.com</p>
                <p>581-748-0646</p>
            </div>
        </div>

        <div class="confirmation__resumeItems">
            {{--      LA BOUCLE D'AFFICHAGE VA ÊTRE ICI      --}}
            <div class="confirmation__resumeItems__item">
                <div class="conteneurItem">
                    <img class="couvertureLivre" src="liaisons/images/couvertures-livres/L97828944851871_carre.jpg">
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
                    <img class="couvertureLivre" src="liaisons/images/couvertures-livres/L97828944851871_carre.jpg">
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

        <button class="transaction__centrer transaction__bouton">IMPRIMER LE REÇU DE VOTRE COMMANDE</button>
        <a class="transaction__centrer lienRetour text-center" href="index.php?controleur=site&action=accueil">CONTINUER À MAGASINER</a>
    </div>
@endsection
