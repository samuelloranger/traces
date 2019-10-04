@extends('gabarit')

@section('contenu')
    <div class="">
        <img style="max-width: 150px" src="{{ $livre -> getImageUrl() }}" alt="Couverture du livre {{ $livre -> titre }}">
        <div class="info__principales">
            <div class="infosPrincipales">
                    <p class="infosPrincipales__auteurs">
                        @foreach($livre -> getAuteurs() as $auteur)
                            {{ $auteur -> getNomPrenom() }}
                        @endforeach
                    </p>

                    <h1 class="infosPrincipales__titre">{{ $livre -> titre }}</h1>
                    <h2 class="infosPrincipales__sousTitre">{{ $livre -> sous_titre }}</h2>
                </div>

            <div class="zonePanier">
                <div class="zonePanier__prix">
                    <p>{{ $livre -> prix }}$</p>
                    <p>{{ $livre -> getParution() }}</p>
                </div>
                <form class="zonePanier__optionsPanier">
                    <div class="options">
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

                    <input type="submit" class="zonePanier__bouton btn btnPanier" value="Ajouter au panier">
                </form>
            </div>
        </div>
    </div>

    <div class="infos">
        <p class="infos__description">{{ $livre -> getDescriptionNettoyee() }}</p>

        <div class="conteneurTiroir">
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


@endsection