@extends('gabarit')

@section('contenu')

    <h1>Panier</h1>
    <div>
        @if(count($elementsPanier) != 0)
            @foreach($elementsPanier as $item)
                <div style="background-color:cornflowerblue">
                    <h2>{{ $item -> livre -> titre }}</h2>
                    <h3>Par @foreach($item -> livre -> getAuteurs() as $auteur) {{ $auteur->getNomPrenom() }} @endforeach</h3>
                    <form>
                        <input type="hidden" name="controleur" value="panier">
                        <input type="hidden" name="action" value="updateItem">

                        <label for="qte">Quantité</label>
                        <select name="qte">
                            @for($intCtr = 1; $intCtr <= 10; $intCtr++)
                                <option @if($item->quantite == $intCtr) selected @endif>{{ $intCtr }}</option>
                            @endfor
                        </select>
                        <input type="hidden" name="isbn" value="{{$item->livre->isbn}}">

                        <input id="updatePanier" type="submit" value="Mettre à jour">
                    </form>
                    <p><a href="index.php?controleur=panier&action=supprimerItem&isbn={{ $item->livre->isbn }}">Supprimer l'item du panier</a></p>

                    <p>Prix par livre: {{ $item->livre->getPrix() }}</p>
                    <p>Prix total livre: {{ $item->getMontantTotalFormate() }}</p>
                </div>
            @endforeach

            <p>Sous-total: {{ $montantSousTotal }}</p>
            <p>Livraison: {{ $fraisLivraison }}</p>
            <p>Taxes: {{ $montantTPS }}</p>
            <p>Total: {{ $montantTotal }}</p>
        @else
            <h2>Le panier est vide.</h2>
        @endif
    </div>

@endsection