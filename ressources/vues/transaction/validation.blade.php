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

@endsection
