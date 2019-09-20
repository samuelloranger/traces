@extends('gabarit')

@section('contenu')

    @include("livres.fragments.pagination")

    @foreach($arrLivres as $livre)
        <ul>
            <li><b>ID:</b> {{ $livre -> id }}</li>
            <li><b>Titre:</b> {{ $livre -> titre }}</li>
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