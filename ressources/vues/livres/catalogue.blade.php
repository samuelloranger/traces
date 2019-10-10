@extends('gabarit')

@section('contenu')
    <main class="container">
        <div class="row">
            <div class="row dropdown">
                <button onclick="ouvrirFermerCategories()" class="align-self-center dropbtn">CATÉGORIES</button>
                <div id="myDropdown" class="dropdown-content">
                    <form method="post" action="{{$urlPagination}}">
                        <input type="submit" value="APPLIQUER" class="catalogue__categories__appliquer catalogue__btn catalogue__btn--categories" />
                        <a href="{{$urlPagination}}" class="catalogue__categories__reinitialiser catalogue__btn catalogue__btn--categories">RÉINITIALISER</a>
                        <ul class="catalogue__categories__liste">
                            @foreach($arrCategories as $categorie)
                                <li class="catalogue__categories__liste__item">
                                    <input type="checkbox" value="{{$categorie -> nom_fr}}" name="categories">
                                    {{$categorie -> nom_fr}}
                                </li>
                            @endforeach
                        </ul>
                    </form>
                </div>
            </div>
            <div class="catalogue__categories col-md-3">
                <p class="catalogue__categories__titre">
                    CATÉGORIES
                </p>
                <button name="appliquer" id="appliquer"
                        class="catalogue__categories__appliquer catalogue__btn catalogue__btn--categories">APPLIQUER
                </button>
                <button name="reinitialiser" id="reinitialiser"
                        class="catalogue__categories__reinitialiser catalogue__btn catalogue__btn--categories">
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
                <div class="catalogue__rangee--1">
                    <input type="text" class="catalogue__rechercher">
                    <input type="submit" class="catalogue__rechercher catalogue__rechercher__bouton" value="Rechercher">
                    <div class="row catalogue__nbParPages">
                        <p class="catalogue__nbParPages__label">Nombre de livres par pages :</p>
                        <a class="catalogue__lien catalogue__lien"
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
                        <option value="alphabetique">Ordre alphabétique</option>
                        <option value="prixCroissant">Prix: du plus bas au plus élevé</option>
                        <option value="prixDécroissant">Prix: du plus élevé au plus bas</option>
                    </select>
                    <div class="catalogue__affichage">
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
                            <li><a class="catalogue__btn catalogue__btn--enSavoirPlus"
                                   href="index.php?controleur=livre&action=fiche&idLivre={{ $livre -> id }}">EN SAVOIR
                                    PLUS</a></li>
                            <li><a class="catalogue__btn catalogue__btn--ajouterPanier" href="">AJOUTER AU PANIER</a>
                            </li>
                        </ul>
                    @endforeach
                </div>
                @include("livres.fragments.pagination")
            </div>
        </div>
    </main>
    <script>
        function ouvrirFermerCategories() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // window.onclick = function(event) {
        //     if (!event.target.matches('.dropbtn')) {
        //         var dropdowns = document.getElementsByClassName("dropdown-content");
        //         var i;
        //         for (i = 0; i < dropdowns.length; i++) {
        //             var openDropdown = dropdowns[i];
        //             if (openDropdown.classList.contains('show')) {
        //                 openDropdown.classList.remove('show');
        //             }
        //         }
        //     }
        //
        // }

    </script>
@endsection