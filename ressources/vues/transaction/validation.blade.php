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
            <p>Date de livraison estimée :</p>
            <div class="validation__sommaire">
                <p class="transaction__sous-titre">Sommaire de la commande</p>
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
                <button>Modifier</button>
            </div>
        </div>
        <h2 class="transaction__titre">Mon panier</h2>
        <p>{{$titre}}</p>
        <p>{{$auteur}}</p>
        <p>{{$prix}}</p>
        <p>Quantité :</p>
        <select>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
        </select>
    {{--    @foreach($elementsPanier as $item)--}}

    {{--    @endforeach--}}
@endsection
