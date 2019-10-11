@extends('gabarit')

@section('image_accueil')
    <div class="image_accueil">
        <div class="image_accueil__conteneur">
            <div class="image_accueil__conteneur__contenu">
{{--                <h1>Traces</h1>--}}
                <div class="image_accueil__conteneur__contenu__logo">
                    <img src="../public/liaisons/images/logo-traces.svg" alt="">
                </div>

            </div>
        </div>
        <picture class="image_accueil__picture">
            <source media="(max-width: 850px)" srcset="../public/liaisons/images/accueil/background_accueil_mobile.jpg">
            <source media="(min-width: 850px)" srcset="../public/liaisons/images/accueil/background_accueil_desktop.jpg">
            <img src="../public/liaisons/images/accueil/background_accueil_desktop.jpg" alt="image de la librairie">
        </picture>
    </div>
@endsection
@section('contenu')
    <div class="accueil">
        <div class="nouveautes">
            <h2>NOUVEAUTES</h2>
            <div class="nouveautes__groupe row">
                @for($indexLivre = 0; $indexLivre < 2; $indexLivre++)
                    {{--                <p>{{$arrNouveautes[$indexLivre]->isbn}}</p>--}}
                    <div class="nouveautes__vignette col-md-6 row">
                        <div class="nouveautes__vignette__image col-6">
                            <img src="{{$arrNouveautes[$indexLivre]->getImageUrl("carre")}}" alt="">
                        </div>
                        <div class="nouveautes__vignette__details col-6">
                            <h3 class="nouveautes__vignette__details__titre">{{$arrNouveautes[$indexLivre]->titre}}</h3>
                            <ul>
                                <li>
                                    <ul>
                                        <li class="nouveautes__vignette__details__auteur">
                                            {{$arrNouveautes[$indexLivre]->getAuteurs()[0]->getNomPrenom()}}
                                            @if(count($arrNouveautes[$indexLivre]->getAuteurs()) > 1)
                                                <span> et autres...</span>
                                            @endif
                                        </li>
{{--                                        @foreach($arrNouveautes[$indexLivre]->getAuteurs() as $auteur)--}}
{{--                                            <li class="nouveautes__vignette__details__auteur">{{$auteur->getNomPrenom()}}</li>--}}
{{--                                        @endforeach--}}
                                    </ul>
                                </li>
                                <li><h3 class="nouveautes__vignette__details__prix">{{$arrNouveautes[$indexLivre]->prix}}$</h3></li>
                            </ul>
                            <div class="nouveautes__vignette__details__boutons">
                                <a href="index.php?controleur=livre&action=fiche&isbn={{$arrNouveautes[$indexLivre]->isbn}}" class="nouveautes__vignette__bouton_plus">EN SAVOIR PLUS</a>
                                <a href="#" class="nouveautes__vignette__bouton_panier">AJOUTER AU PANIER</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="coupsCoeur">
            <h2>COUPS DE COEUR</h2>
            <div class="coupsCoeur__groupe row">
                @for($indexLivre = 0; $indexLivre < 3; $indexLivre++)
                    <div class="coupsCoeur__groupe__vignette col-md-6 col-lg-4">
                        <div class="coupsCoeur__groupe__vignette__image">
                            <div class="coupsCoeur__groupe__vignette__image__foreground">
                            </div>
                            <img src="{{$arrCoupsCoeur[$indexLivre]->getImageUrl("carre")}}" alt="">
                        </div>
                        <div class="coupsCoeur__groupe__vignette__details">
                            <div class="coupsCoeur__groupe__vignette__details__info">
                                <h3 class="coupsCoeur__groupe__vignette__details__titre">{{$arrCoupsCoeur[$indexLivre]->titre}}</h3>
                                <ul>
                                    <li>
                                        <ul>
                                            @foreach($arrCoupsCoeur[$indexLivre]->getAuteurs() as $auteur)
                                                <li class="coupsCoeur__groupe__vignette__details__auteur">{{$auteur->getNomPrenom()}}</li>
                                            @endforeach
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="coupsCoeur__groupe__vignette__boutons">
                                <h3 class="coupsCoeur__groupe__vignette__details__prix">{{$arrCoupsCoeur[$indexLivre]->prix}}$</h3>
                                <a href="index.php?controleur=livre&action=fiche&isbn={{$arrCoupsCoeur[$indexLivre]->isbn}}" class="coupsCoeur__groupe__vignette__boutons__bouton_plus">EN SAVOIR PLUS</a>
                                <a href="#" class="coupsCoeur__groupe__vignette__boutons__bouton_panier">AJOUTER AU PANIER</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>

        <div class="actualites">
            <h2>ACTUALITES</h2>
            <div class="actualites__groupe row">
                @for($indexArticle = 0; $indexArticle < 3; $indexArticle++)
                    <div class="actualites__vignette col-md-6 col-lg-4">
                        <div class="actualites__vignette__contenu">
                            <div>
                                <h3>{{$arrActualites[$indexArticle]->titre}}</h3>
                                <span class="actualites__vignette__contenu__auteur">{{$arrActualites[$indexArticle]->getAuteur()->getNomPrenom()}}</span>
                                <div class="actualites__vignette__contenu__texte">
                                    {{$arrActualites[$indexArticle]->getTexteTronque()}}
                                </div>
                            </div>
                            <div>

                                <a href="#" class="actualites__vignette__bouton_suite">LIRE LA SUITE</a>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
        </div>
    </div>
@endsection

