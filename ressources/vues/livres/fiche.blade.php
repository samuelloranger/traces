@extends('gabarit')

@section('contenu')
    <div class="fiche">
        <div class="infosPrincipales row">
            <div class="col-sm-12 col-md-3">
                <img style="max-width: 200px" src="{{ $livre -> getImageUrl() }}" alt="Couverture du livre {{ $livre -> titre }}">
            </div>

            <div class="info__principales col-sm-12 col-md-9">
                <div class="infosPrincipales">
                        <p class="infosPrincipales__auteurs">
                            @foreach($livre -> getAuteurs() as $auteur)
                                {{ $auteur -> getNomPrenom() }}
                            @endforeach
                        </p>

                        <h1 class="infosPrincipales__titre">{{ $livre -> titre }}</h1>
                        <h2 class="infosPrincipales__sousTitre">{{ $livre -> sous_titre }}</h2>
                    </div>

                <div class="zonePanier row">
                    <div class="zonePanier__prix col-sm-12 col-md-3">
                        <p>{{ $livre -> prix }}$</p>
                        <p>{{ $livre -> getParution() }}</p>
                    </div>
                    <form class="zonePanier__optionsPanier col-sm-12 col-md-9 row">
                        <div class="options col-sm-12 col-md-6">
                            <label for="formatLivre">Choisir un format...</label>
                            <select id="formatLivre">
                                <option>Sélectionnez un format...</option>
                                <option value="papier">Papier</option>
                                <option value="papier">E-Pub</option>
                                <option value="papier">PDF</option>
                            </select>

                            <label for="Quantité">Quantité</label>
                            <select id="quantite">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                            </select>
                        </div>

                        <input type="submit" class="zonePanier__bouton btn btnPanier col-sm-12 col-md-6" value="Ajouter au panier">
                    </form>
                </div>
            </div>
        </div>

        <div class="infosSecondaires row">
            <p class="infos__description col-sm-12 col-md-6">{{ $livre -> getDescriptionNettoyee() }}</p>

            <div class="conteneurTiroir col-sm-12 col-md-6">
                <h2>Voir plus d'informations</h2>
                <ul>
                    <li><b>Nombre de pages:</b> {{ $livre -> nbre_pages }}</li>
                    <li><b>Année de publication</b>{{ $livre -> annee_publication }}</li>
                    <li><b>Langue: </b>{{ $livre -> langue }}</li>
                    <li><b>ISBN: </b>{{ $livre -> isbn }}</li>
                    @if($livre -> autres_caracteristiques != "")
                        <li><b>Autres caractéristiques</b>{{ $livre -> autres_caracteristiques }}</li>
                    @endif
                    @if($livre -> est_coup_de_coeur)
                        <li><b>Ce livre est marqué comme un coup de coeur</b>{{ $livre -> est_coup_de_coeur }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="infosTerciaires row">
            <div class="infosTerciaires__zoneGauche col-sm-12 col-md-6">
                <div class="">
                    @if(count($arrRecensions) > 0)
                        <div class="zoneRecensions">
                            <h2>Ce livre a fait parler de lui...</h2>
                            @foreach($arrRecensions as $recension)
                                <div class="review">
                                    <p class="review__titre">{{ $recension -> date }}</p>
                                    <p class="review__description">{{ $recension -> description }}</p>
                                    <p>{{ $recension -> nom_journaliste }}, {{ $recension -> nom_media }}</p>

        à                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-md-1"></div>

            <div class="infosTerciaires__zoneDroite col-sm-12 col-md-5">
                @if(count($arrHonneurs) > 0)
                    <div class="zoneReview">
                        <h2>Prix remportés</h2>
                        @foreach($arrHonneurs as $honneur)
                            <div class="review">
                                <h3 class="review__titre">{{ $honneur -> nom }}</h3>
                                <p class="review__description">{{ $honneur -> getDescriptionNettoyee() }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection