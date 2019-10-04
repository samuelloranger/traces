@extends('gabarit')

@section('contenu')
    <h3>Je suis la page {{$nomPage}} et je parle de l'accueil!</h3>

    <div class="nouveautes">
        <h2>NOUVEAUTES</h2>
        @for($indexLivre = 0; $indexLivre < 2; $indexLivre++)
            <div class="nouveautes__vignette">
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
        @endfor
    </div>

    <div class="coupsCoeur">
        <h2>COUPS DE COEUR</h2>
        @for($indexLivre = 0; $indexLivre < 3; $indexLivre++)
            <div class="coupsCoeur__vignette">
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
@endsection

