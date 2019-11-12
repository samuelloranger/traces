@extends('transaction.gabarit')

@section('contenu')
    <div class="transaction">
        <div class="validation__etape transaction__centrer">
            <p class="validation__etape__non-actif">1. Livraison</p>
            <p class="validation__etape__non-actif">2. Facturation</p>
            <p class="validation__etape__actif">3. Validation</p>
        </div>
        <h1 class="transaction__titre">Validation de la commande</h1>
        <div class="transaction__background">
            <a class="transaction__centrer transaction__bouton"
               href="index.php?controleur=validation&action=confirmation">PASSER LA COMMANDE</a>
            <p>Livraison à <b>{{$nomComplet}}</b></p>
            <p>Date de livraison estimée : <b>{{$dateLivraisonEstimee}}</b></p>
            <div class="validation__sommaire">
                <p class="transaction__sous-titre">Sommaire de la commande</p>
                <p><span class="texteGauche">Sous-total ({{ $nbrItemsPanier }} items):</span> <span
                            class="texteDroit">{{ $montantSousTotal }}</span></p>
                <p class="fraisLivraison"><span class="texteGauche">Frais de livraison: </span><span
                            class="texteDroit">{{ $fraisLivraison }}</span></p>
                <p><span class="texteGauche">Taxes:</span> <span class="texteDroit">{{ $montantTPS }}</span></p>
                <p><span class="texteGauche">Total:</span> <span class="texteDroit">{{ $montantTotal }}</span></p>
                <a class="transaction__centrer transaction__bouton"
                   href="index.php?controleur=validation&action=confirmation">PASSER LA COMMANDE</a>
            </div>
            <div class="validation__adresseLivraison">
                <p class="transaction__sous-titre">Adresse de livraison</p>
                <p>
                    {{$nomComplet}}<br/>
                    {{$adresse}}<br/>
                    {{$ville}}<br/>
                    {{$province}}<br/>
                    {{$codePostal}}
                </p>
                <button>Modifier</button>
            </div>
            <div class="validation__infoFacturation">
                <p class="transaction__sous-titre">Informations de facturation</p>
                <p>Mode de paiement : carte de crédit</p>
                <p>XXXX XXXX XXXX {{$noCarte}}</p>
                <p>Expiration : {{$dateExpiration}}</p>
                <button>Modifier</button>
                <p class="transaction__sous-titre">Adresse de facturation</p>
                <p>
                    {{$nomComplet}}<br/>
                    {{$adresse}}<br/>
                    {{$ville}}<br/>
                    {{$province}}<br/>
                    {{$codePostal}}
                </p>
                <button>Modifier</button>
                <p class="transaction__sous-titre">Informations</p>
                <p>{{$courriel}}</p>
                <p>+1 (418) 999-9999</p>
                <button>Modifier</button>
            </div>
        <h2 class="transaction__titre">Mon panier</h2>
        @foreach($elementsPanier as $item)
            <div class="panier__items__item row">
                <div class="sectionGauche col-md-3 col-lg-3">
                    <a class="sectionGauche__image"
                       href="index.php?controleur=livre&action=fiche&isbn={{ $item -> livre -> isbn }}">
                        <img src="{{ $item -> livre -> getImageUrl("carre") }}"
                             alt="Image de {{ $item -> livre -> titre }}"/>
                    </a>
                    <div class="sectionGauche__contenuMobile">
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
                    <p class="infosLivre__btnSupprimer">
                        <a class="lienSupprItemNoScript"
                           href="index.php?controleur=panier&action=supprimerItem&isbn={{ $item->livre->isbn }}">Supprimer
                            l'item du panier</a>
                        <button type="button" value="{{ $item -> livre -> isbn }}" class="lienSupprItemScript">Supprimer
                            l'item du panier
                        </button>
                    </p>
                    <form action="index.php?controleur=panier&action=updateItem" method="POST">
                        <input type="hidden" class="isbn" name="isbn" value="{{$item->livre->isbn}}">
                        <label for="qte">Quantité</label>
                        <div class="boutons row">
                            <div class="select col-sm-12 col-md-6">
                                <select name="qte" class="qteItem">
                                    <option value="0">0 (supprimer)</option>
                                    @for($intCtr = 1; $intCtr <= 10; $intCtr++)
                                        <option value="{{ $intCtr }}"
                                                @if($item->quantite == $intCtr) selected @endif>{{ $intCtr }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <button class="updatePanier col-sm-12 col-md-6" id="updatePanier">Mettre à jour</button>
                        </div>
                    </form>
                </div>
                <div class="sectionDroite col-md-3 col-lg-4">
                    <p class="prixLivre">{{ $item->livre->getPrix() }}</p>
                    <p class="sousTotal">Sous-total: {{ $item->getMontantTotalFormate() }}</p>
                </div>
            </div>
        @endforeach
        <h2 class="transaction__titre">Résumé de la commande</h2>
            <p><span class="texteGauche">Sous-total ({{ $nbrItemsPanier }} items):</span> <span
                        class="texteDroit">{{ $montantSousTotal }}</span></p>
        <p class="fraisLivraison"><span class="texteGauche">Frais de livraison: </span><span
                    class="texteDroit">{{ $fraisLivraison }}</span></p>
        <div class="fraisLivraironSelect">
            <label for="fraisLivraisonSelect">Livraison</label>
            <select id="fraisLivraisonSelect">
                <option @if($modeLivraison == "payante") selected @endif value="payante">Rapide</option>
                <option @if($modeLivraison == "gratuite") selected @endif value="gratuite">Gratuite</option>
            </select>
        </div>
        <p class="dateLivraisonEstimee">
            <span>Date de livraison estimée:</span>
            <span class="date datePayante">{{ $dateLivraisonEstimee }}</span>
        </p>
        <p><span class="texteGauche">Taxes:</span> <span class="texteDroit">{{ $montantTPS }}</span></p>
        <p><span class="texteGauche">Total:</span> <span class="texteDroit">{{ $montantTotal }}</span></p>
        <a class="transaction__centrer transaction__bouton"
           href="index.php?controleur=validation&action=confirmation">PASSER LA COMMANDE</a>
        </div>
    </div>
@endsection
