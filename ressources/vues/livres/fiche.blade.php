@extends('gabarit')

@section('contenu')
    @include('fragments.filAriane')

    <div class="fiche">
        <div class="infosPrincipales row">
            <div class="zoneImage col-sm-12 col-md-3">
                <img class="zoneImage__image" style="" src="{{ $livre -> getImageUrl() }}" alt="Couverture du livre {{ $livre -> titre }}">
            </div>

            <div class="zoneInfos col-sm-12 col-md-9">
                <div class="zoneInfos__infosLivre">
                        <p class="zoneInfos__infosLivre__auteurs">
                            @foreach($arrAuteurs as $id => $auteur)
                                {{ $auteur -> getNomPrenom() }}@if($id < count($arrAuteurs)-1), @endif
                            @endforeach
                        </p>

                    <h1 class="zoneInfos__infosLivre__titre">{{ $livre -> titre }}</h1>
                    <h2 class="zoneInfos__infosLivre__sousTitre">{{ $livre -> sous_titre }}</h2>
                </div>

                <div class="zoneInfos__zonePanier row">
                    <div class="zoneInfos__zonePanier__prixDispo col-sm-12 col-md-3">
                        <p class="prix">{{ $livre -> getPrix() }}*</p>
                        <p class="disponibilite">{{ $livre -> getParution() }}</p>
                    </div>

                    <form action="index.php?controleur=panier&action=ajoutPanier&redirection=fiche&isbn={{ $livre -> isbn }}" method="POST" class="zoneInfos__zonePanier__optionsPanier col-sm-12 col-md-9 row">
                        <div class="options col-sm-12 col-md-6">
                            <label for="formatLivre">Choisir un format...</label>
                            <div class="select">
                                <select name="format" id="formatLivre" class="formatLivre">
                                    <option>Format...</option>
                                    <option value="Papier">Papier</option>
                                    <option value="E-Pub">E-Pub</option>
                                    <option value="PDF">PDF</option>
                                </select>
                                <span class="fleche"><span class="arrow-down"></span></span>
                            </div>

                            <label class="labelQte" for="Quantité">Quantité</label>
                            <div class="selectionQte">
                                <span class="btnChangementQte btnChangementQte__soustraire">-</span>
                                <input name="qte" type="text" min="1" max="10" maxlength="2" class="qteCourante" value="1">
                                <span class="btnChangementQte btnChangementQte__additionner">+</span>
                            </div>
                        </div>

                        <div class="zoneBouton col-sm-12 col-md-6">
                            <button type="button" class="btn btnPanier btnAjoutPanierScript">Ajouter au panier</button>
                            <button class="btn btnPanier btnAjoutPanierNoScript">Ajouter au panier</button>
                            <p class="texteFraisLivraison">* Frais de livraison calculés au panier</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="infosSecondaires row">
            <div class="infos__description col-sm-12 col-md-6">
                <h2>Résumé</h2>
                <p>{{ $livre -> description }}</p>
            </div>

            <div class="col-md-1"></div>

            <div class="conteneurTiroir col-md-5">
                <h2>Plus d'informations</h2>
                <ul>
                    @if($livre -> collection_id != "")
                        <li>
                            <span>
                                <b>Collection:</b> {{ $arrInfosCollection->nom }}
                                @if($arrInfosCollection -> description != "")
                                    : {!! $arrInfosCollection -> description !!}
                                @endif
                            </span>
                        </li>
                    @endif
                    <li>
                        <span><b>Editeur:</b>
                            @forEach($arrEditeurs as $id => $editeur)
                                <a href="{{ $editeur->url }}">{{ $editeur->nom }}</a>@if(count($arrEditeurs) && $id != count($arrEditeurs)-1 ), @endif
                            @endforeach
                        </span>
                    </li>
                    <li><b>Nombre de pages:</b> {{ $livre -> nbre_pages }}</li>
                    <li><b>Année de publication: </b>{{ $livre -> annee_publication }}</li>
                    <li><b>Langue: </b>{{ $livre -> langue }}</li>
                    <li><b>ISBN: </b>{{ $livre -> isbn }}</li>
                    @if($livre -> autres_caracteristiques != "")
                        <li><b>Autres caractéristiques: </b>{{ $livre -> autres_caracteristiques }}</li>
                    @endif
                    @if($livre -> est_coup_de_coeur)
                        <li><b>Ce livre est marqué comme un coup de coeur</b>{{ $livre -> est_coup_de_coeur }}</li>
                    @endif
                </ul>
            </div>
        </div>

        <div class="infosTerciaires row">
            @if(count($arrRecensions) > 0)
                <div class="infosTerciaires__zoneGauche col-sm-12 col-md-6">
                    <div class="zoneRecensions">
                        <h2>Ce livre a fait parler de lui...</h2>
                        @foreach($arrRecensions as $recension)
                            <div class="review">
                                <h3 class="review__titre">{{ $recension -> titre }}</h3>
                                <p class="review__date">{{ $recension -> date }}</p>
                                <p class="review__description">{{ $recension -> description }}</p>
                                <p><span class="review__nomAuteur">{{ $recension -> nom_journaliste }}</span>, {{ $recension -> nom_media }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(count($arrRecensions) > 0)
                <div class="col-md-1"></div>
            @endif


            <div @if(count($arrRecensions) > 0) class="infosTerciaires__zoneDroite col-sm-12 col-md-5" @else class="infosTerciaires__zoneDroite col-sm-12 col-md-12" @endif>
                @if(count($arrHonneurs) > 0)
                    <div class="zonePrix">
                        <h2>Prix remportés</h2>
                        @foreach($arrHonneurs as $honneur)
                            <div class="prix">
                                <h3 class="prix__titre">{{ $honneur -> nom }}</h3>
                                <p class="prix__description">{{ $honneur -> description }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="zoneCommentaires col-md-12">
                <h2>Commentaires de lecteurs</h2>
                @include("livres.fragments.commentaires")
            </div>
        </div>
    </div>
@endsection