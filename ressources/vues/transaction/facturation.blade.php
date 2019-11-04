@extends('transaction.gabarit')

@section('contenu')
    <div class="transaction">
        <div class="facturation__etape transaction__centrer">
            <p class="facturation__etape__non-actif">1. Livraison</p>
            <p class="facturation__etape__actif">2. Facturation</p>
            <p class="facturation__etape__non-actif">3. Validation</p>
        </div>
        <h1 class="transaction__titre">Facturation</h1>

        <div class="transaction__background">
            <p class="transaction__sous-titre">Informations de paiement</p>
            <div class="facturation__radio">
                <input class="facturation__input" type="radio">
                <p class="facturation__radio--label">Paypal</p>
            </div>
            <div class="facturation__radio">
                <input class="facturation__input" type="radio">
                <p class="facturation__radio--label">Carte de crédit</p>
            </div>
            <p class="facturation__carteAcceptees">Cartes de crédit acceptées</p>
            <div class="facturation__methodesPaiement">
                <img class="facturation__methode" src="liaisons/images/transaction/visa.svg" alt="visa">
                <img class="facturation__methode" src="liaisons/images/transaction/mastercard.svg" alt="mastercard">
                <img class="facturation__methode" src="liaisons/images/transaction/american-express.svg" alt="american express">
            </div>
            <a class="transaction__centrer transaction__bouton"
               href="index.php?controleur=transaction&action=validation">CONTINUER</a>
        </div>
    </div>
@endsection
