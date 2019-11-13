@extends('transaction.gabarit')

@section('contenu')
    <div class="confirmation">
        <h1 class="transaction__titre">Confirmation</h1>
        <div class="transaction__centrer">
            <div class="transation__messageGeneral">
                <span class="icone__validation"></span>
                <h2 class="transaction__sous-titre">Nous avons bien reçu votre commande.</h2>
            </div>
            <p>Elle vous sera expédiée selon les modalitées que vous avez choisies.
                N'hésitez pas à consulter notre service à la clientèle pour plus d'informations relatives à votre
                commande ou votre compte.</p>
            <p><i>Votre numéro de confirmation est le:</i></p>
            <p class="transaction__titre"><b>1234-5678-90</b></p>
            <p>Vous recevrez d'ici quelques minutes une confirmation de votre commande par courriel.</p>
        </div>

        <div class="transaction__background confirmation__resumeCommande">
            <div class="confirmation__resumeCommande__zoneInfo">
                <p class="transaction__sous-titre">Sommaire de votre commande</p>
                <div class="infoPanierFlex text-right">
                    <p>{{ $nbrItemsPanier }} items</p>
                    <p>CAD {{ $montantSousTotal }} </p>
                </div>
                <div class="infoPanierFlex text-right">
                    <p>TPS 5%</p>
                    <p>CAD {{ $montantTPS }}</p>
                </div>
                <div class="infoPanierFlex text-right">
                    <p>Livraison standard</p>
                    <p>CAD {{ $fraisLivraison }}</p>
                </div>
                <div class="infoPanierFlex text-right">
                    <p>Total</p>
                    <p>CAD {{ $montantTotal }}</p>
                </div>
            </div>

            <div class="confirmation__resumeCommande__zoneInfo">
                <p class="transaction__sous-titre">Adresse de livraison</p>
                <p>{{$nomComplet}}</p>
                <p>{{$adresse}}</p>
                <p>{{$ville}}</p>
                <p>{{$province}}</p>
                <p>{{$codePostal}}</p>
            </div>

            <div class="confirmation__resumeCommande__zoneInfo">
                <p class="transaction__sous-titre">Adresse de facturation</p>
                <p>{{$nomComplet}}</p>
                <p>{{$adresse}}</p>
                <p>{{$ville}}</p>
                <p>{{$province}}</p>
                <p>{{$codePostal}}</p>
            </div>

            <div class="confirmation__resumeCommande__zoneInfo">
                <p class="transaction__sous-titre">Mode de paiement</p>
                <p>{{$nomComplet}}</p>

                <div class="mode-paiement">
                    @if($methodePaiement === "VISA")
                        <img class="logo" src="liaisons/images/transaction/visa.svg" alt="visa">
                    @endif
                    @if($methodePaiement === "Master Card")
                        <img class="logo" src="liaisons/images/transaction/mastercard.svg" alt="Mastercard">
                    @endif
                    @if($methodePaiement === "American Express")
                        <img class="logo" src="liaisons/images/transaction/american-express.svg" alt="AMEX">
                    @endif
                    <p class="numeroCarte">XXXX XXXX XXXX <b>{{$noCarte}}</b></p>
                </div>
            </div>

            <div class="transaction__resumePanier zone">
                <p class="transaction__sous-titre">Informations</p>
                <p>{{$courriel}}</p>
                <p>+1 (418) 999-9999</p>
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
        <a class="transaction__centrer lienRetour text-center" href="index.php?controleur=site&action=accueil">CONTINUER
            À MAGASINER</a>
    </div>
@endsection
