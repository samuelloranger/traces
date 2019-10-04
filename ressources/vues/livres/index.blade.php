@extends('gabarit')

@section('contenu')

    @include("livres.fragments.pagination")

    @foreach($arrLivres as $livre)
        <ul>
            <li><img style="max-width: 150px" src="{{ $livre -> getImageUrl() }}" alt="Couverture du livre {{ $livre -> titre }}">
            </li>
            <li><b>ID:</b> {{ $livre -> id }}</li>
            <li><b>Titre:</b> <a href="index.php?controleur=livre&action=fiche&idLivre={{ $livre -> id }}">{{ $livre -> titre }}</a></li>
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