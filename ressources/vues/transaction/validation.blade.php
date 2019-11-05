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
               href="index.php?controleur=transaction&action=confirmation">PASSER LA COMMANDE</a>
            {{--    À COMPLÉTER AVEC INFOS DE L'UTILISATEUR        --}}
            <p>Livraison à </p>
            <p>Date de livraison estimée :</p>
            <div class="validation__sommaire">
                <p class="transaction__sous-titre">Sommaire de la commande</p>
            </div>
            <div class="validation__adresseLivraison">
                <p class="transaction__sous-titre">Adresse de livraison</p>
            </div>
            <div class="validation__infoFacturation">
                <p class="transaction__sous-titre">Informations de facturation</p>
               <p>Mode de paiement : carte de crédit</p>
                <button>Modifier</button>
                <p>Adresse de facturation</p>
                <button>Modifier</button>
                <p>Informations</p>
                <button>Modifier</button>
            </div>
        </div>
        <h2 class="transaction__titre">Mon panier</h2>
        @if(count($elementsPanier) != 0)
            <div class="panier__items col-md-12 col-lg-9">
                @foreach($elementsPanier as $item)
                    <div class="panier__items__item row">
                        <div class="sectionGauche col-md-3 col-lg-3">
                            <a class="sectionGauche__image" href="index.php?controleur=livre&action=fiche&isbn={{ $item -> livre -> isbn }}">
                                <img src="{{ $item -> livre -> getImageUrl("carre") }}" alt="Image de {{ $item -> livre -> titre }}"/>
                            </a>

                            <div class="sectionGauche__contenuMobile">
                                <p class="h2 infosLivre__titreLivre"><a href="index.php?controleur=livre&action=fiche&isbn={{ $item -> livre -> isbn }}">{{ $item -> livre -> titre }}</a></p>
                                <p class="infosLivre__auteurLivre">
                                    @foreach($item -> livre -> getAuteurs() as $id => $auteur)
                                        {{ $auteur->getNomPrenom() }}@if($id !== count($item -> livre -> getAuteurs())-1), @endif
                                    @endforeach
                                </p>

                            </div>
                        </div>

@endsection
