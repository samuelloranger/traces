@extends('gabarit')

@section('contenu')

    <h1>Panier</h1>
    <div class="panier row">
        @if(count($elementsPanier) != 0)
            <div class="panier__items col-md-9">
                @foreach($elementsPanier as $item)
                    <div class="panier__items__item row">
                        <div class="infosLivre col-md-5">
                            <p class="infosLivre__titreLivre">{{ $item -> livre -> titre }}</p>
                            <p class="infosLivre__auteurLivre">Par @foreach($item -> livre -> getAuteurs() as $auteur) {{ $auteur->getNomPrenom() }} @endforeach</p>
                        </div>
                        <div class="formLivre col-md-3">
                            <form>
                                <input type="hidden" name="controleur" value="panier">
                                <input type="hidden" name="action" value="updateItem">

                                <label for="qte">Quantité</label>
                                <select name="qte">
                                    <option value="0">0 (supprimer)</option>
                                    @for($intCtr = 1; $intCtr <= 10; $intCtr++)
                                        <option value="{{ $intCtr }}" @if($item->quantite == $intCtr) selected @endif>{{ $intCtr }}</option>
                                    @endfor
                                </select>
                                <input type="hidden" name="isbn" value="{{$item->livre->isbn}}">

                                <input id="updatePanier" type="submit" value="Mettre à jour">
                            </form>

                            <p><a href="index.php?controleur=panier&action=supprimerItem&isbn={{ $item->livre->isbn }}">Supprimer l'item du panier</a></p>
                        </div>

                        <div class="prixLivre col-md-4">

                            <p>Prix par livre: {{ $item->livre->getPrix() }}</p>
                            <p>Prix total livre: {{ $item->getMontantTotalFormate() }}</p>
                        </div>

                    </div>
                @endforeach
            </div>
            <div class="panier__infosPanier col-md-3">
                <div class="contenu">
                    <p>Sous-total: {{ $montantSousTotal }}</p>
                    <p>Livraison: {{ $fraisLivraison }}</p>
                    <p>Taxes: {{ $montantTPS }}</p>
                    <p>Total: {{ $montantTotal }}</p>
                    <button class="">Payer</button>
                </div>
            </div>

        @else
            <h2>Le panier est vide.</h2>
        @endif
    </div>

@endsection