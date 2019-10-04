@extends('gabarit')

@section('contenu')
    <h3>Je suis la page {{$nomPage}} et je parle de l'accueil!</h3>


    @for($indexLivre = 0; $indexLivre < 3; $indexLivre++)
        <p>Titre du livre: {{$arrCoupsCoeur[$indexLivre]->titre}}</p>
        <ul>
            <li>Prix: {{$arrCoupsCoeur[$indexLivre]->prix}}$</li>
            <li>
                Auteur(s):
                <ul>
                    @foreach($arrCoupsCoeur[$indexLivre]->getAuteurs() as $auteur)
                        <li>{{$auteur->getNomPrenom()}}</li>
                    @endforeach
                </ul>
            </li>
        </ul>
    @endfor
@endsection

