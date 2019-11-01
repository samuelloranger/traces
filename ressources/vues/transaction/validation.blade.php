@extends('transaction.gabarit')

@section('contenu')
    <div class="transaction">
        <div class="validation__etape transaction__centrer">
            <p class="validation__etape__non-actif">1. Livraison</p>
            <p class="validation__etape__non-actif">2. Facturation</p>
            <p class="validation__etape__actif">3. Validation</p>
        </div>
        <h1 class="transaction__titre">Validation</h1>

        <div class="transaction__background">
            <p class="transaction__sous-titre">Sommaire de la commande</p>
            <a class="transaction__centrer transaction__bouton"
               href="index.php?controleur=transaction&action=confirmation">CONTINUER</a>
        </div>
    </div>
@endsection
