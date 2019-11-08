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
            <form action="index.php?controleur=livraison&action=insererAdresseSession" method="post">
                <p class="livraison__label">Nom :</p>
                <input class="livraison__input" type="text" name="nom" value="{{$nom}}"/>
                <span></span>
                <p class="livraison__label">Prénom :</p>
                <input class="livraison__input" type="text" name="prenom" value="{{$prenom}}"/>
                <p class="livraison__label">Adresse :</p>
                <input class="livraison__input" type="text" name="adresse" value="{{$adresse}}"/>
                <p class="livraison__label">Ville :</p>
                <input class="livraison__input" type="text" name="ville" value="{{$ville}}"/>
                <p class="livraison__label">Province :</p>
                <select class="livraison__input" name="abbrProvince">
                    <option value="AB">Alberta</option>
                    <option value="BC">British Columbia</option>
                    <option value="MB">Manitoba</option>
                    <option value="NB">New Brunswick</option>
                    <option value="NL">Newfoundland and Labrador</option>
                    <option value="NS">Nova Scotia</option>
                    <option value="ON">Ontario</option>
                    <option value="PE">Prince Edward Island</option>
                    <option value="QC" selected>Quebec</option>
                    <option value="SK">Saskatchewan</option>
                    <option value="NT">Northwest Territories</option>
                    <option value="NU">Nunavut</option>
                    <option value="YT">Yukon</option>
                </select>
                <p class="livraison__label">Code Postal : <span class="livraison__label--exemple">Ex.: A1A 1A1</span>
                </p>
                <input class="livraison__input" type="text" name="codePostal" value="{{$codePostal}}"/>
                <div class="livraison__checkbox">
                    <input name="estDefaut" type="checkbox" checked/>
                    <p class="livraison__checkbox--label">Adresse de livraison par défaut</p>
                </div>
                <div class="livraison__checkbox">
                    <input name="adresseFacturation" type="checkbox" checked/>
                    <p class="livraison__checkbox--label">Utiliser comme adresse de facturation</p>
                </div>
                <input type="submit" class="transaction__centrer transaction__bouton" value="LIVRER À CETTE ADRESSE"/>
            </form>
        </div>
    </div>
@endsection
