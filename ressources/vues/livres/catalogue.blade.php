@extends('gabarit')

@section('contenu')
    <main class="container">
        <div class="row">
            <div class="col-md-3 catalogue__categories">
                <p class="catalogue__categories__titre">
                    CATÉGORIES
                </p>
                <button name="appliquer" id="appliquer" class="catalogue__categories__appliquer">APPLIQUER</button>
                <button name="reinitialiser" id="reinitialiser" class="catalogue__categories__reinitialiser">
                    RÉINITIALISER
                </button>
                <ul class="catalogue__categories__liste">
                    @foreach($arrCategories as $categorie)
                        <li class="catalogue__categories__liste__item">
                            <input type="checkbox" name="{{$categorie -> nom_fr}}">
                            {{$categorie -> nom_fr}}
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-9 catalogue__contenu">
                <div class="row catalogue__rangee--1">
                    <input type="text" class="catalogue__rechercher">
                    <input type="submit" class="catalogue__rechercher catalogue__rechercher__bouton" value="Rechercher">
                    <div class="row catalogue__nbParPages">
                        <p class="catalogue__nbParPages__label">Nombre de livres par pages :</p>
                        <a class="catalogue__lien--actif"
                           href="index.php?controleur=livre&action=catalogue&nbParPages=9">9</a>
                        <a class="catalogue__lien"
                           href="index.php?controleur=livre&action=catalogue&nbParPages=36">36</a>
                        <a class="catalogue__lien"
                           href="index.php?controleur=livre&action=catalogue&nbParPages=72">72</a>
                    </div>
                </div>
                <div class="row catalogue__rangee--2">
                    <p class="col-sm-12 col-md- catalogue__nbResultatsRecherche">*Nombre de livres trouvées*</p>
                    <label for="catalogue__trier">Trier par :</label>
                    <select class="catalogue__trier" id="catalogue__trier">
                        <option value="">Aucun</option>
                        <option value="populaire">Les plus populaires</option>
                        <option value="alphabetique">Ordre alphabétique</option>
                        <option value="prixCroissant">Prix: du plus bas au plus élevé</option>
                        <option value="prixDécroissant">Prix: du plus élevé au plus bas</option>
                    </select>
                    <div class="row catalogue__affichage">
                        <p class="catalogue__affichage__label">Affichage :</p>
                        <a class="catalogue__affichage__icone--actif"
                           href="index.php?controleur=livre&action=catalogue&affichage=rangees">Rangées</a>
                        <a class="catalogue__affichage__icone"
                           href="index.php?controleur=livre&action=catalogue&affichage=cartes">Cartes</a>
                    </div>
                </div>
                <div class="catalogue__lesLivres">
                    @foreach($arrLivres as $livre)
                        <ul class="catalogue__livre">
                            <li><img style="max-width: 150px" src="{{ $livre -> getImageUrl() }}"
                                     alt="Couverture du livre {{ $livre -> titre }}">
                            </li>
                            <li><b>ID:</b> {{ $livre -> id }}</li>
                            <li><b>Titre:</b> <a
                                        href="index.php?controleur=livre&action=fiche&isbn={{ $livre -> isbn }}">{{ $livre -> titre }}</a>
                            </li>
                            <li><b>Nombre de pages:</b> {{ $livre -> nbre_pages }}</li>
                            <li><b>Parution:</b> {{ $livre -> getParution() }}</li>
                            <li><b>Auteurs:</b>
                                <ul>
                                    @foreach($livre -> getAuteurs() as $auteur)
                                        <li>{{ $auteur -> getNomPrenom() }}</li>
                                    @endforeach
                                </ul>
                            <li><a class="catalogue__bouton--enSavoirPlus" href="">EN SAVOIR PLUS</a></li>
                            <li><a class="catalogue__bouton--ajouterAuPanier" href="">AJOUTER AU PANIER</a></li>
                        </ul>
                    @endforeach
                </div>
                @include("livres.fragments.pagination")
            </div>
        </div>
    </main>
@endsection