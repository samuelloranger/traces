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
            <form action="index.php?controleur=facturation&action=insererModePaiementSession" method="post">
                <div class="facturation__radio">
                    <input name="methodePaiement" class="facturation__input" type="radio" value="Paypal">
                    <p class="facturation__radio--label">Paypal</p>
                </div>
                <p class="facturation__carteAcceptees">Cartes de crédit acceptées</p>
                <div class="facturation__methodesPaiement">
                    <div class="facturation__radio">
                        <input name="methodePaiement" class="facturation__input" type="radio" value="VISA">
                        <img class="facturation__methode" src="liaisons/images/transaction/visa.svg" alt="visa">
                    </div>
                    <div class="facturation__radio">
                        <input name="methodePaiement" class="facturation__input" type="radio" value="Master Card">
                        <img class="facturation__methode" src="liaisons/images/transaction/mastercard.svg"
                             alt="mastercard">
                    </div>
                    <div class="facturation__radio">
                        <input name="methodePaiement" class="facturation__input" type="radio" value="American Express">
                        <img class="facturation__methode" src="liaisons/images/transaction/american-express.svg"
                             alt="american express">
                    </div>
                </div>
                <p>Nom :</p>
                <input type="text" name="nomComplet" value="{{$nomComplet}}"/>
                @if($tValidation['champsValide']['nom'] == false)
                    <p class="transaction__messageErreur">{{$tValidation['champs']['nom']['message']}}</p>
                @endif
                <p>Numéro de la carte :</p>
                <input type="text" name="noCarte" value="{{$noCarte}}"/>
                @if($tValidation['champsValide']['numeroCarte'] == false)
                    <p class="transaction__messageErreur">{{$tValidation['champs']['numeroCarte']['message']}}</p>
                @endif
                <p>Code de sécurité :</p>
                <input type="text" name="code" value="{{$code}}"/>
                @if($tValidation['champsValide']['code'] == false)
                    <p class="transaction__messageErreur">{{$tValidation['champs']['code']['message']}}</p>
                @endif
                <p>Date d'expiration :<span class="livraison__label--exemple">Ex.: 01/20</span></p>
                <input type="text" name="dateExpirationCarte" value="{{$dateExpirationCarte}}"/>
                @if($tValidation['champsValide']['dateExpiration'] == false)
                    <p class="transaction__messageErreur">{{$tValidation['champs']['dateExpiration']['message']}}</p>
                @endif
                <div class="facturation__adresseFacturation">
                    <p class="transaction__sous-titre">Adresse de facturation</p>
                    <p class="facturation__nom">{{$nom}}</p>
                    <p class="facturation__prenom">{{$prenom}}</p>
                    <p class="facturation__adresse">{{$adresse}}</p>
                    <p class="facturation__ville">{{$ville}}</p>
                    <p class="facturation__province">{{$province}}</p>
                    <p class="facturation__codePostal">{{$codePostal}}</p>
                    <button>Modifier</button>
                </div>
                <div class="facturation__infoContact">
                    <p class="transaction__sous-titre">Informations de contact</p>
                    <p class="facturation__courriel"><i>Courriel :</i><b>{{ $courriel }}</b></p>
                    <p class="facturation__telephone"><i>Téléphone : </i><b>+1 (418) 999-9999</b></p>
                </div>
                <input type="submit" class="transaction__centrer transaction__bouton" value="VALIDER LA COMMANDE"/>
            </form>
        </div>
    </div>
@endsection
