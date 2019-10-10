@extends('gabarit')

@section('contenu')
    <h3>Je suis la page {{$nomPage}} et je parle de l'accueil!</h3>

    <div class="nouveautes">
        <h2>NOUVEAUTES</h2>
        <div class="nouveautes__groupe row">
            @for($indexLivre = 0; $indexLivre < 2; $indexLivre++)
{{--                <p>{{$arrNouveautes[$indexLivre]->isbn}}</p>--}}
                <div class="nouveautes__vignette col-md-6">
                    <div class="nouveautes__vignette__image">
                        <img src="{{$arrNouveautes[$indexLivre]->getImageUrl("carre")}}" alt="">
                    </div>
                    <div class="nouveautes__vignette__details">
                        <ul>
                            <li>{{$arrNouveautes[$indexLivre]->titre}}</li>
                            <li>
                                Auteurs:
                                <ul>
                                    @foreach($arrNouveautes[$indexLivre]->getAuteurs() as $auteur)
                                        <li>{{$auteur->getNomPrenom()}}</li>
                                    @endforeach
                                </ul>
                            </li>
                            <li>Prix: {{$arrNouveautes[$indexLivre]->prix}}$</li>
                        </ul>
                        <a href="#">EN SAVOIR PLUS</a>
                        <a href="#">AJOUTER AU PANIER</a>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <div class="coupsCoeur">
        <h2>COUPS DE COEUR</h2>
        <div class="coupsCoeur__groupe row">
            @for($indexLivre = 0; $indexLivre < 3; $indexLivre++)
                <div class="coupsCoeur__vignette col-md-4">
                    <img src="{{$arrCoupsCoeur[$indexLivre]->getImageUrl("carre")}}" alt="">
                    <ul>
                        <li>{{$arrCoupsCoeur[$indexLivre]->titre}}</li>
                        <li>
                            <ul>
                                @foreach($arrCoupsCoeur[$indexLivre]->getAuteurs() as $auteur)
                                    <li>{{$auteur->getNomPrenom()}}</li>
                                @endforeach
                            </ul>
                        </li>
                        <li>Prix: {{$arrCoupsCoeur[$indexLivre]->prix}}$</li>
                    </ul>
                    <a href="#">EN SAVOIR PLUS</a>
                    <a href="#">AJOUTER AU PANIER</a>
                </div>
            @endfor
        </div>
    </div>

    <div class="actualites">
        <h2>ACTUALITES</h2>
        <div class="actualites__groupe row">
            @for($indexArticle = 0; $indexArticle < 3; $indexArticle++)
                <div class="actualites__vignette col-md-4">
                    <h4>{{$arrActualites[$indexArticle]->titre}}</h4>
                    <h5>{{$arrActualites[$indexArticle]->getAuteur()->getNomPrenom()}}</h5>
                    <div>
                        {{$arrActualites[$indexArticle]->getTexteTronque()}}
                    </div>
                    <a href="#">LIRE LA SUITE</a>
                </div>
            @endfor
        </div>
    </div>
@endsection

