@extends('gabarit')

@section('contenu')

    <h1>Panier</h1>

    <div class="panier__resumeCourt">
        <p class="sous-total">
            <span class="sous-total__texteGauche">Sous-total ({{ count($elementsPanier) }} items):</span>
            <span class="sous-total__texteDroit">{{ $montantSousTotal }}</span>
        </p>

        <p class="texteLivraisonGratuite">Admissible à la livraison gratuite</p>

        <a href="" class="btnCommander">Passer la commande</a>
    </div>

    <div class="panier row">
        @if(count($elementsPanier) != 0)
            <div class="panier__items col-md-12 col-lg-9">
                @foreach($elementsPanier as $item)
                    <div class="panier__items__item row">
                        <div class="sectionGauche col-md-3 col-lg-3">
                            <a class="sectionGauche__image" href="index.php?controleur=livre&action=fiche&isbn={{ $item -> livre -> isbn }}">
                                <img src="{{ $item -> livre -> getImageUrl("carre") }}" alt="Image de {{ $item -> livre -> titre }}"/>
                            </a>

                            <div class="sectionGauche__contenuMobile">
                                <p class="h2 infosLivre__titreLivre"><a href="index.php?controleur=livre&action=fiche&isbn={{ $item -> livre -> isbn }}">{{ $item -> livre -> titre }}</a></p>
                                <p class="infosLivre__auteurLivre">
                                    @foreach($item -> livre -> getAuteurs() as $id => $auteur)
                                        {{ $auteur->getNomPrenom() }}@if($id !== count($item -> livre -> getAuteurs())-1),@endif
                                    @endforeach
                                </p>

                            </div>
                        </div>

                        <div class="sectionCentre col-md-6 col-lg-6">
                            <div class="infosLivre">
                                <p class="h2 infosLivre__titreLivre"><a href="index.php?controleur=livre&action=fiche&isbn={{ $item -> livre -> isbn }}">{{ $item -> livre -> titre }}</a></p>
                                <p class="infosLivre__auteurLivre">
                                    @foreach($item -> livre -> getAuteurs() as $id => $auteur)
                                        {{ $auteur->getNomPrenom() }}@if($id !== count($item -> livre -> getAuteurs())-1),@endif
                                    @endforeach
                                </p>
                            </div>

                            <p class="infosLivre__btnSupprimer">
                                <a class="lienSupprItemNoScript" href="index.php?controleur=panier&action=supprimerItem&isbn={{ $item->livre->isbn }}">Supprimer l'item du panier</a>
                                <button type="button" value="{{ $item -> livre -> isbn }}" class="lienSupprItemScript">Supprimer l'item du panier</button>
                            </p>

                            <form action="index.php?controleur=panier&action=updateItem">
                                <input type="hidden" id="isbnLivre" name="isbn" value="{{$item->livre->isbn}}">

                                <label for="qte">Quantité</label>

                                <div class="boutons row">
                                    <div class="select col-sm-12 col-md-6">
                                        <select name="qte">
                                            <option value="0">0 (supprimer)</option>
                                            @for($intCtr = 1; $intCtr <= 10; $intCtr++)
                                                <option value="{{ $intCtr }}" @if($item->quantite == $intCtr) selected @endif>{{ $intCtr }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <button class="updatePanier col-sm-12 col-md-6" id="updatePanier">Mettre à jour</button>
                                </div>
                            </form>

                        </div>

                        <div class="sectionDroite col-md-3 col-lg-3">
                            <p class="prixLivre">{{ $item->livre->getPrix() }}</p>
                            <p class="sousTotal">Sous-total: {{ $item->getMontantTotalFormate() }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="panier__infosPanier col-md-12 col-lg-3">
                <div class="contenu">
                    <p class="h2">Résumé de la commande</p>
                    <p><span class="texteGauche">Sous-total ({{ count($elementsPanier) }} items):</span> <span class="texteDroit">{{ $montantSousTotal }}</span></p>

                    <p class="fraisLivraison"><span class="texteGauche">Frais de livraison:</span><span class="texteDroit">{{ $fraisLivraison }}</span></p>

                    <div class="fraisLivraironSelect">
                        <label for="fraisLivraironSelect">Livraison</label>
                        <select id="fraisLivraisonSelect">
                            <option @if($typeLivraison == "payante") selected @endif>Rapide</option>
                            <option @if($typeLivraison == "gratuite") selected @endif>Gratuite</option>
                        </select>
                    </div>

                    <p class="dateLivraisonEstimee">
                        <span>Date de livraison estimée:</span>
                        <span class="date datePayante">{{ $dateLivraisonEstimee }}</span>
                    </p>

                    <p><span class="texteGauche">Taxes:</span> <span class="texteDroit">{{ $montantTPS }}</span></p>
                    <p><span class="texteGauche">Total:</span> <span class="texteDroit">{{ $montantTotal }}</span></p>

                    <div class="zoneBoutons">
                        <a href="index.php?controleur=transaction&action=transaction" class="btn btnCommander">Passer la commande</a>
                        <a href="" class="btn btnViderPanier">Vider le panier</a>
                    </div>
                </div>
            </div>

        @else
            <h2>Le panier est vide.</h2>
        @endif
    </div>

@endsection
