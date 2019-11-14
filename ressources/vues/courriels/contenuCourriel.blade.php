<div class="confirmation">
    <div class="transaction">
        <h1 class="transaction__titre">TRACES</h1>
        <h2>Confirmation de commande</h2>
        <div class="transaction__centrer">
            <div class="transation__messageGeneral">
                <span class="icone__validation"></span>
                <h2 class="transaction__sous-titre">Nous avons bien reçu votre commande.</h2>
            </div>
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
            <p class="transaction__sous-titre">Mode de paiement</p>
            <p>{{$nomComplet}}</p>
        </div>
        <div class="confirmation__modePaiement">
            @if($methodePaiement === "VISA")
{{--                <img class="confirmation__modePaiement__logo" src="liaisons/images/transaction/visa.svg" alt="visa">--}}
                <p>VISA</p>
            @endif
            @if($methodePaiement === "Master Card")
{{--                <img class="confirmation__modePaiement__logo" src="liaisons/images/transaction/mastercard.svg" alt="Mastercard">--}}
                <p>Master Card</p>
            @endif
            @if($methodePaiement === "American Express")
{{--                <img class="confirmation__modePaiement__logo" src="liaisons/images/transaction/american-express.svg" alt="AMEX">--}}
                <p>AMEX</p>
            @endif
            <p class="confirmation__modePaiement__numeroCarte">XXXX XXXX XXXX <b>{{$noCarte}}</b></p>
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
        <div class="transaction__resumePanier zone">
            <p class="transaction__sous-titre">Informations</p>
            <p>{{$courriel}}</p>
            <p>+1 (418) 999-9999</p>
        </div>
        <div class="confirmation__resumeItems">
            <p class="transaction__sous-titre">Mes livres</p>
            @foreach($elementsPanier as $item)
                <div class="panier__items__item row">
                    <div class="sectionGauche col-md-3 col-lg-3">
{{--                        <div class="sectionGauche__image">--}}
{{--                            <img src="{{ $item -> livre -> getImageUrl("carre") }}"--}}
{{--                                 alt="Image de {{ $item -> livre -> titre }}"/>--}}
{{--                        </div>--}}
                        <div class="sectionGauche__contenuMobile">
                            <p class="h2 infosLivre__titreLivre">{{ $item -> livre -> titre }}</p>
                            <p class="infosLivre__auteurLivre">
                                @foreach($item -> livre -> getAuteurs() as $id => $auteur)
                                    {{ $auteur->getNomPrenom() }}@if($id !== count($item -> livre -> getAuteurs())-1)
                                        , @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <div class="sectionCentre col-md-6 col-lg-5">
                        <div class="infosLivre">
                            <p class="h2 infosLivre__titreLivre"><a
                                        href="index.php?controleur=livre&action=fiche&isbn={{ $item -> livre -> isbn }}">{{ $item -> livre -> titre }}</a>
                            </p>
                            <p class="infosLivre__auteurLivre">
                                @foreach($item -> livre -> getAuteurs() as $id => $auteur)
                                    {{ $auteur->getNomPrenom() }}@if($id !== count($item -> livre -> getAuteurs())-1)
                                        , @endif
                                @endforeach
                            </p>
                        </div>
                    </div>
                    <div class="sectionDroite col-md-3 col-lg-4">
                        <p class="prixLivre">{{ $item->livre->getPrix() }}</p>
                        <p class="sousTotal">Sous-total: {{ $item->getMontantTotalFormate() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
{{--<div class="confirmation">--}}
{{--    <div class="transaction">--}}
{{--        <h1 class="transaction__titre">Confirmation</h1>--}}
{{--        <div class="transaction__centrer">--}}
{{--            <div class="transation__messageGeneral">--}}
{{--                <span class="icone__validation"></span>--}}
{{--                <h2 class="transaction__sous-titre">Nous avons bien reçu votre commande.</h2>--}}
{{--            </div>--}}
{{--            <p class="confirmation__espacement">Elle vous sera expédiée selon les modalitées que vous avez choisies. N'hésitez pas à consulter notre service à la clientèle pour plus d'informations relatives à votre commande ou votre compte.</p>--}}
{{--            <p><b>Votre numéro de confirmation est le:</b></p>--}}
{{--            <p><b>XXXXXXXXXXXXX</b></p>--}}
{{--            <p>Vous recevrez d'ici quelques minutes une confirmation de votre commande par courriel.</p>--}}
{{--        </div>--}}

{{--        <div class="transaction__background confirmation__resumeCommande">--}}
{{--            <div class="confirmation__resumeCommande__zoneInfo">--}}
{{--                <h3 class="transaction__sous-titre">Sommaire de votre commande</h3>--}}
{{--                <div class="infoPanierFlex text-right confirmation__espacement">--}}
{{--                    <p>3 items</p>--}}
{{--                    <p>CAD 68,95$</p>--}}
{{--                </div>--}}
{{--                <div class="infoPanierFlex text-right">--}}
{{--                    <p>TPS 5%</p>--}}
{{--                    <p>CAD 4,45$</p>--}}
{{--                </div>--}}
{{--                <div class="infoPanierFlex text-right">--}}
{{--                    <p>Livraison standard</p>--}}
{{--                    <p>CAD 4,45$</p>--}}
{{--                </div>--}}
{{--                <div class="infoPanierFlex text-right">--}}
{{--                    <p>Total</p>--}}
{{--                    <p>CAD 4,45$</p>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="confirmation__resumeCommande__zoneInfo">--}}
{{--                <h3 class="transaction__sous-titre">Adresse de livraison</h3>--}}
{{--                <p class="confirmation__espacement">Prénom nom</p>--}}
{{--                <p>133 Rue Sieur Nicol</p>--}}
{{--                <p>Québec</p>--}}
{{--                <p>QC</p>--}}
{{--                <p>G1G 1G1</p>--}}
{{--            </div>--}}

{{--            <div class="confirmation__resumeCommande__zoneInfo">--}}
{{--                <h3 class="transaction__sous-titre">Adresse de facturation</h3>--}}
{{--                <p class="confirmation__espacement">Prénom nom</p>--}}
{{--                <p>133 Rue Sieur Nicol</p>--}}
{{--                <p>Québec</p>--}}
{{--                <p>QC</p>--}}
{{--                <p>G1G 1G1</p>--}}
{{--            </div>--}}

{{--            <div class="confirmation__resumeCommande__zoneInfo">--}}
{{--                <h3 class="transaction__sous-titre">Mode de paiement</h3>--}}
{{--                <p class="confirmation__espacement">Nom prénom</p>--}}

{{--                <div class="mode-paiement">--}}
{{--                    --}}{{--        Ici tu envoie le mode de paiement sélectionné, tu pourras changer la source de l'image ensuite        --}}
{{--                    <img class="logo" src="liaisons/images/transaction/visa.svg" alt="visa">--}}
{{--                    --}}{{--                <img class="logo" src="liaisons/images/transaction/mastercard.svg" alt="Mastercard">--}}
{{--                    --}}{{--                <img class="logo" src="liaisons/images/transaction/american-express.svg" alt="AMEX">--}}
{{--                    <p class="numeroCarte">XXXX XXXX XXXX 1234</p>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="transaction__resumePanier zone">--}}
{{--                <h3 class="transaction__sous-titre">Informations</h3>--}}
{{--                <p class="confirmation__espacement">samuelloranger@gmail.com</p>--}}
{{--                <p>581-748-0646</p>--}}
{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="confirmation__resumeItems">--}}
{{--            --}}{{--      LA BOUCLE D'AFFICHAGE VA ÊTRE ICI      --}}
{{--            <div class="confirmation__resumeItems__item">--}}
{{--                <div class="conteneurItem">--}}
{{--                    <img class="couvertureLivre" src="liaisons/images/couvertures-livres/L97828944851871_carre.jpg">--}}
{{--                    <div class="titreAuteur">--}}
{{--                        <h4>Les chroniques d'une mère indigne</h4>--}}
{{--                        <p>Caroline Allard</p>--}}
{{--                    </div>--}}

{{--                    <div class="prixItem">--}}
{{--                        <p>Total (2):</p>--}}
{{--                        <p>18.95$</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="confirmation__resumeItems__item">--}}
{{--                <div class="conteneurItem">--}}
{{--                    <img class="couvertureLivre" src="liaisons/images/couvertures-livres/L97828944851871_carre.jpg">--}}
{{--                    <div class="titreAuteur">--}}
{{--                        <h4>Les chroniques d'une mère indigne</h4>--}}
{{--                        <p>Caroline Allard</p>--}}
{{--                    </div>--}}

{{--                    <div class="prixItem">--}}
{{--                        <p>Total (2):</p>--}}
{{--                        <p>18.95$</p>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}