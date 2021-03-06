@extends('gabarit')

@section('image_accueil')
    <div class="image_accueil">
        <div class="image_accueil__conteneur">
            <div class="image_accueil__conteneur__contenu">
                <h1 style="display: none;">Traces</h1>
                <div class="image_accueil__conteneur__contenu__logo">
                    <img src="liaisons/images/logo-traces.svg" alt="">
                    <h1>L'histoire de l'avant</h1>

                </div>
                <div class="lien_contenu">
                    <a href="#nouveautes">DÉCOUVREZ NOS NOUVEAUTÉS</a>
                </div>
            </div>

        </div>
        <picture class="image_accueil__picture">
            <source media="(max-width: 850px)" srcset="liaisons/images/accueil/background_accueil_mobile.jpg">
            <source media="(min-width: 850px)" srcset="liaisons/images/accueil/background_accueil_desktop.jpg">
            <img src="liaisons/images/accueil/background_accueil_desktop.jpg" alt="image de la librairie">
        </picture>
    </div>
@endsection
@section('contenu')
    <div class="accueil">
        <div class="nouveautes" id="nouveautes">
            <h2>NOUVEAUTÉS</h2>
            <div class="nouveautes__groupe row">
                @for($indexLivre = 0; $indexLivre < 2; $indexLivre++)
                    {{--                <p>{{$arrNouveautes[$indexLivre]->isbn}}</p>--}}
                    <div class="nouveautes__vignette col-md-6">
                        <div class="nouveautes__vignette__image">
                            <div class="nouveautes__vignette__image__foreground">
                                <div class="nouveautes__vignette__details">
                                    <div>
                                        <h3 class="nouveautes__vignette__details__titre">{{$arrNouveautes[$indexLivre]->titre}}</h3>
                                        <div>
                                            <ul>
                                                <li class="nouveautes__vignette__details__auteur">
                                                    {{$arrNouveautes[$indexLivre]->getAuteurs()[0]->getNomPrenom()}}
                                                    @if(count($arrNouveautes[$indexLivre]->getAuteurs()) > 1)
                                                        <span> et autres...</span>
                                                    @endif
                                                </li>
                                            </ul>

                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="nouveautes__vignette__details__prix">{{$arrNouveautes[$indexLivre]->prix}}$</h3>
                                        <div class="nouveautes__vignette__details__boutons">
                                            <a href="index.php?controleur=livre&action=fiche&nouveaute&isbn={{$arrNouveautes[$indexLivre]->isbn}}" class="nouveautes__vignette__bouton_plus">EN SAVOIR PLUS</a>
                                            <form action="index.php?controleur=panier&action=ajoutPanier&redirection=accueil&isbn={{$arrCoupsCoeur[$indexLivre]->isbn}}" method="POST">
                                                <input type="hidden" name="qte" value="1" hidden>

                                                <button class="nouveautes__vignette bouton_panier bouton_panierNoScript">AJOUTER AU PANIER</button>
                                                <button type="button" class="nouveautes__vignette bouton_panier bouton_panierScript" value="{{ $arrNouveautes[$indexLivre]->isbn }}">AJOUTER AU PANIER</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <img src="{{$arrNouveautes[$indexLivre]->getImageUrl("carre")}}" alt="">
                        </div>
                    </div>
                @endfor
            </div>
            <div class="row">
                <div class="col-lg-4 ml-auto">
                    <a href="index.php?controleur=livre&action=catalogue" class="bouton_voir_plus">VOIR TOUTES LES NOUVEAUTÉS</a>
                </div>

            </div>
        </div>

        <div class="coupsCoeur" id="coupdecoeurs">
            <h2>COUPS DE COEUR</h2>
            <div class="coupsCoeur__groupe row">
                @for($indexLivre = 0; $indexLivre < 3; $indexLivre++)
                    <div class="coupsCoeur__groupe__vignette col-md-6 col-lg-4">
                        <div class="coupsCoeur__groupe__vignette__image">
                            <div class="coupsCoeur__groupe__vignette__image__foreground">
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
                                        <a href="index.php?controleur=livre&action=fiche&coupCoeur&isbn={{$arrCoupsCoeur[$indexLivre]->isbn}}" class="coupsCoeur__groupe__vignette__boutons__bouton_plus">EN SAVOIR PLUS</a>
                                        <form action="index.php?controleur=panier&action=ajoutPanier&redirection=accueil&isbn={{$arrCoupsCoeur[$indexLivre]->isbn}}" method="POST">
                                            <input type="hidden" name="qte" value="1" hidden>

                                            <button class="coupsCoeur__groupe__vignette__boutons bouton_panier bouton_panierNoScript">AJOUTER AU PANIER</button>
                                            <button type="button" class="coupsCoeur__groupe__vignette__boutons bouton_panier bouton_panierScript" value="{{ $arrNouveautes[$indexLivre]->isbn }}">AJOUTER AU PANIER</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <img src="{{$arrCoupsCoeur[$indexLivre]->getImageUrl("carre")}}" alt="">
                        </div>

                    </div>
                @endfor
            </div>
            <div class="row">
                <div class="col-lg-4 ml-auto">
                    <a href="index.php?controleur=livre&action=catalogue" class="bouton_voir_plus">VOIR TOUS LES COUPS DE COEUR</a>
                </div>
            </div>
        </div>

        <div class="actualites">
            <h2>ACTUALITÉS</h2>
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
            <div class="row">
                <div class="col-lg-4 ml-auto">
                    <a href="#" class="bouton_voir_plus">VOIR TOUTES LES ACTUALITÉS</a>
                </div>
            </div>
        </div>
    </div>
@endsection

