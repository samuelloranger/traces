@extends('transaction.gabarit')

@section('contenu')
    <div class="transaction">
        <div class="livraison__etape transaction__centrer">
            <p class="livraison__etape__actif">1. Livraison</p>
            <p class="livraison__etape__non-actif">2. Facturation</p>
            <p class="livraison__etape__non-actif">3. Validation</p>
        </div>
        <h1 class="transaction__titre">Livraison</h1>

        <div class="transaction__background">
            <p class="transaction__sous-titre">Adresse de livraison</p>
            <form>
                <p class="livraison__label">Nom :</p>
                <input class="livraison__input" type="text"/>
                <p class="livraison__label">Prénom :</p>
                <input class="livraison__input" type="text"/>
                <p class="livraison__label">Adresse :</p>
                <input class="livraison__input" type="text"/>
                <p class="livraison__label">Ville :</p>
                <input class="livraison__input" type="text"/>
                <p class="livraison__label">Province :</p>
                <select class="livraison__input">
                    <option value="AB">Alberta</option>
                    <option value="BC">British Columbia</option>
                    <option value="MB">Manitoba</option>
                    <option value="NB">New Brunswick</option>
                    <option value="NL">Newfoundland and Labrador</option>
                    <option value="NS">Nova Scotia</option>
                    <option value="ON">Ontario</option>
                    <option value="PE">Prince Edward Island</option>
                    <option value="QC">Quebec</option>
                    <option value="SK">Saskatchewan</option>
                    <option value="NT">Northwest Territories</option>
                    <option value="NU">Nunavut</option>
                    <option value="YT">Yukon</option>
                </select>
                <p class="livraison__label">Code Postal : <span class="livraison__label--exemple">Ex.: A1A 1A1</span>
                </p>
                <input class="livraison__input" type="text"/>
                <div class="livraison__checkbox">
                    <input name="par_defaut" type="checkbox" value="par_defaut" checked/>
                    <p class="livraison__checkbox--label">Adresse de livraison par défaut</p>
                </div>
                <div class="livraison__checkbox">
                    <input name="adresse_facturation" type="checkbox" value="adresse_facturation" checked/>
                    <p class="livraison__checkbox--label">Utiliser comme adresse de facturation</p>
                </div>

            </form>
            <a class="transaction__centrer transaction__bouton"
               href="index.php?controleur=transaction&action=facturation">LIVRER À CETTE ADRESSE </a>
        </div>
    </div>
@endsection
