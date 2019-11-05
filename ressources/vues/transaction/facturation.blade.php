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
            {{-- À COMPLÉTER: BALISE FORM --}}
            <form action="" method="">
                <div class="facturation__radio">
                    <input name="methode_paiement" class="facturation__input" type="radio">
                    <p class="facturation__radio--label">Paypal</p>
                </div>
                <div class="facturation__radio">
                    <input name="methode_paiement"  class="facturation__input" type="radio">
                    <p class="facturation__radio--label">Carte de crédit</p>
                </div>
                <p class="facturation__carteAcceptees">Cartes de crédit acceptées</p>
                <div class="facturation__methodesPaiement">
                    <img class="facturation__methode" src="liaisons/images/transaction/visa.svg" alt="visa">
                    <img class="facturation__methode" src="liaisons/images/transaction/mastercard.svg" alt="mastercard">
                    <img class="facturation__methode" src="liaisons/images/transaction/american-express.svg"
                         alt="american express">
                </div>
                <p>Nom :</p>
                <input type="text"/>
                <p>Numéro de la carte :</p>
                <input type="text"/>
                <p>Code de sécurité :</p>
                <input type="text"/>
                <p>Date d'expiration :</p>
                <select>
                    <option selected>MM</option>
                    <option>01</option>
                    <option>02</option>
                    <option>03</option>
                    <option>04</option>
                    <option>05</option>
                    <option>06</option>
                    <option>07</option>
                    <option>08</option>
                    <option>09</option>
                    <option>10</option>
                    <option>11</option>
                    <option>12</option>
                </select>
                <select>
                    <option selected>AAAA</option>
                    <option>2019</option>
                    <option>2020</option>
                    <option>2021</option>
                    <option>2022</option>
                    <option>2023</option>
                    <option>2024</option>
                    <option>2025</option>
                </select>
            </form>
        </div>
        <div class="facturation__adresseFacturation">
            <p class="transaction__sous-titre">Adresse de facturation</p>
            <div class="livraison__checkbox">
                <input name="adresse_facturation" type="checkbox" value="adresse_facturation" checked/>
                <p class="livraison__checkbox--label">Utiliser mon adresse de livraison comme adresse de facturation</p>
            </div>
            {{--    À COMPLÉTER: INFOS SAISIES PAR L'UTILISATEUR        --}}
{{--            <p class="facturation__nom">{{}}</p>--}}
{{--            <p class="facturation__prenom">{{}}</p>--}}
{{--            <p class="facturation__adresse">{{}}</p>--}}
{{--            <p class="facturation__ville">{{}}</p>--}}
{{--            <p class="facturation__province">{{}}</p>--}}
{{--            <p class="facturation__codePostal">{{}}</p>--}}
            <button>Modifier</button>
        </div>
        <div class="facturation__infoContact">
            <p class="transaction__sous-titre">Informations de contact</p>
            <p>Elles seront utilisées pour confirmer votre commande ou vous joindre en cas de besoin pour le suivi de
                votre commande.</p>
            {{--     À COMPLÉTER       --}}
{{--            <p class="facturation__courriel">{{}}</p>--}}
{{--            <p class="facturation__telephone">{{}}</p>--}}
        </div>
        <a class="transaction__centrer transaction__bouton"
           href="index.php?controleur=validation&action=validation">CONTINUER</a>
    </div>
@endsection
