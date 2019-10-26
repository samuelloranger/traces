@extends('gabarit')

@section('contenu')

    <h1>Panier</h1>

    <div class="infosLivraison row">
        <p class="infosLivraison__titre col-12">Calcul des frais de livraison:</p>
        <p class="infosLivraison__description col-12">Un coût de base de 4$ sera ajouté au taux de 3,50$ par item.</p>
    </div>

    <div class="panier row">
        @if(count($elementsPanier) != 0)
            <div class="panier__items col-md-9">
                @foreach($elementsPanier as $item)
                    <div class="panier__items__item row">
                        <div class="sectionDroite col-md-3">
                            <div class="sectionDroite__image">
                                <img src="{{ $item -> livre -> getImageUrl("carre") }}" alt="Image de {{ $item -> livre -> titre }}"/>
                            </div>
                        </div>

                        <div class="sectionCentre col-md-6">
                            <p class="h2 infosLivre__titreLivre"><a href="index.php?controleur=livre&action=fiche&isbn={{ $item -> livre -> isbn }}">{{ $item -> livre -> titre }}</a></p>
                            <p class="infosLivre__auteurLivre">Par @foreach($item -> livre -> getAuteurs() as $auteur) {{ $auteur->getNomPrenom() }} @endforeach</p>

                            <form>
                                <input type="hidden" name="controleur" value="panier">
                                <input type="hidden" name="action" value="updateItem">
                                <input type="hidden" name="isbn" value="{{$item->livre->isbn}}">

                                <label for="qte">Quantité</label>

                                <div class="boutons row">
                                    <div class="select col-md-6">
                                        <select name="qte">
                                            <option value="0">0 (supprimer)</option>
                                            @for($intCtr = 1; $intCtr <= 10; $intCtr++)
                                                <option value="{{ $intCtr }}" @if($item->quantite == $intCtr) selected @endif>{{ $intCtr }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <input class="col-md-6" id="updatePanier" type="submit" value="Mettre à jour">
                                </div>
                            </form>

                            <p><a href="index.php?controleur=panier&action=supprimerItem&isbn={{ $item->livre->isbn }}">Supprimer l'item du panier</a></p>
                        </div>

                        <div class="sectionDroite col-md-3">
                            <p>{{ $item->livre->getPrix() }}</p>
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
