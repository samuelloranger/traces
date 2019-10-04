@extends('gabarit')

@section('contenu')

    @include("livres.fragments.pagination")
    <div class="catalogue__categories">
        <p class="catalogue__categories__titre">
            CATÉGORIES
        </p>
        <button name="appliquer" id="appliquer" class="catalogue__categories__appliquer">APPLIQUER</button>
        <button name="reinitialiser" id="reinitialiser" class="catalogue__categories__reinitialiser">RÉINITIALISER</button>
        <ul class="catalogue__categories__liste">
            @foreach($arrCategories as $categorie)
                <li class="catalogue__categories__liste__item">
                    <input type="checkbox" name="{{$categorie -> nom_fr}}">
                    {{$categorie -> nom_fr}}¢
                </li>
            @endforeach
        </ul>
    </div>
    @foreach($arrLivres as $livre)
        <ul>
            <li><img style="max-width: 150px" src="{{ $livre -> getImageUrl() }}"
                     alt="Couverture du livre {{ $livre -> titre }}">
            </li>
            <li><b>ID:</b> {{ $livre -> id }}</li>
            <li><b>Titre:</b> <a
                        href="index.php?controleur=livre&action=fiche&idLivre={{ $livre -> id }}">{{ $livre -> titre }}</a>
            </li>
            cd ~
            <li><b>Nombre de pages:</b> {{ $livre -> nbre_pages }}</li>
            <li><b>Parution:</b> {{ $livre -> getParution() }}</li>
            <li><b>Auteurs:</b>
                <ul>
                    @foreach($livre -> getAuteurs() as $auteur)
                        <li>{{ $auteur -> getNomPrenom() }}</li>
                    @endforeach
                </ul>
        </ul>
    @endforeach

@endsection