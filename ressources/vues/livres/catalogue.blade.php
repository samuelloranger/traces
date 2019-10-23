@extends('gabarit')

@section('contenu')
    <div class="row">
        <div class="row dropdown">
            <button onclick="ouvrirFermerCategories()" class="dropbtn catalogue__btn--categories ">
                CATÉGORIES
            </button>
            <div id="myDropdown" class="dropdown-content justify-content-center">
                <form method="post" action="{{$urlPagination}}">
                    <a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}"
                       class="catalogue__btn catalogue__btn--reinitialiser">RÉINITIALISER</a>
                    <ul class="catalogue__categories__liste">
                        @foreach($arrCategories as $categorie)
                            <li class="catalogue__categories__liste__item">
                                <a href="index.php?controleur=livre&action=catalogue&categorie={{$categorie -> id}}&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}"
                                   class="catalogue__categories__lien">{{$categorie -> nom_fr}}</a>
                            </li>
                        @endforeach
                    </ul>
                </form>
            </div>
        </div>
        <div class="catalogue__categories col-lg-3">
            <p class="catalogue__categories__titre text-center">
                CATÉGORIES
            </p>
            <div class="catalogue__categories__contenu">
                <a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}"
                   class="catalogue__btn catalogue__categories--reinitialiser">RÉINITIALISER</a>
            <ul class="catalogue__categories__liste">
                @foreach($arrCategories as $categorie)
                    <li class="catalogue__categories__liste__item">
                        <a href="index.php?controleur=livre&action=catalogue&categorie={{$categorie -> id}}&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}"
                           class="catalogue__categories__lien">{{$categorie -> nom_fr}}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        </div>
        <div class="col-lg-9 justify-content-center">
            <div class="catalogue__nbParPages">
                <input type="text" class="catalogue__rechercher">
                <input type="submit" class="catalogue__rechercher catalogue__rechercher__bouton" value="Rechercher">
                <div class="row">
                    <p class="catalogue__nbParPages__label">Nombre de livres par pages :</p>
                    <a class="catalogue__lien catalogue__lien"
                       href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=9">9</a>
                    <a class="catalogue__lien"
                       href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=18">18</a>
                    <a class="catalogue__lien"
                       href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=36">36</a>
                </div>
            </div>
            <div class="row catalogue__trier">
                {{--                    <p class="col-sm-12 col-md- catalogue__nbResultatsRecherche">*Nombre de livres trouvées*</p>--}}
                <label for="catalogue__trier">Trier par :</label>
                <select class="catalogue__trier--select" id="catalogue__trier" onchange=" location = this.value">
                    <option value="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar=aucun&nbParPages={{$_GET['nbParPages']}}"
                            @if(isset($_GET["trierPar"])== 'aucun' OR !isset($_GET["trierPar"]))
                            selected
                            @endif
                    >Aucun
                    </option>
                    <option value="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar=alphabetique&nbParPages={{$_GET['nbParPages']}}"
                            @if(isset($_GET["trierPar"]) AND $_GET["trierPar"] == 'alphabetique')
                            selected
                            @endif>Ordre alphabétique
                    </option>
                    <option value="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar=prixCroissant&nbParPages={{$_GET['nbParPages']}}"
                            @if(isset($_GET["trierPar"]) AND $_GET["trierPar"] == 'prixCroissant')
                            selected
                            @endif>Prix: $ -> $$$
                    </option>
                    <option value="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar=prixDecroissant&nbParPages={{$_GET['nbParPages']}}"
                            @if(isset($_GET["trierPar"]) AND $_GET["trierPar"] == 'prixDecroissant')
                            selected
                            @endif
                    >Prix: $$$ -> $
                    </option>
                </select>
                {{--                    <div class="catalogue__affichage">--}}
                {{--                        <p class="catalogue__affichage__label">Affichage :</p>--}}
                {{--                        <a class="catalogue__affichage__icone--actif"--}}
                {{--                           href="index.php?controleur=livre&action=catalogue&affichage=rangees">Rangées</a>--}}
                {{--                        <a class="catalogue__affichage__icone"--}}
                {{--                           href="index.php?controleur=livre&action=catalogue&affichage=cartes">Cartes</a>--}}
                {{--                    </div>--}}
            </div>

{{--            <div class="coupsCoeur">--}}
{{--                <h2>COUPS DE COEUR</h2>--}}
{{--                <div class="coupsCoeur__groupe row">--}}
{{--                    @for($indexLivre = 0; $indexLivre < 3; $indexLivre++)--}}
{{--                        <div class="coupsCoeur__groupe__vignette col-md-6 col-lg-4">--}}
{{--                            <div class="coupsCoeur__groupe__vignette__image">--}}
{{--                                <div class="coupsCoeur__groupe__vignette__image__foreground">--}}
{{--                                </div>--}}
{{--                                <img src="{{$arrCoupsCoeur[$indexLivre]->getImageUrl("carre")}}" alt="">--}}
{{--                            </div>--}}
{{--                            <div class="coupsCoeur__groupe__vignette__details">--}}
{{--                                <div class="coupsCoeur__groupe__vignette__details__info">--}}
{{--                                    <h3 class="coupsCoeur__groupe__vignette__details__titre">{{$arrCoupsCoeur[$indexLivre]->titre}}</h3>--}}
{{--                                    <ul>--}}
{{--                                        <li>--}}
{{--                                            <ul>--}}
{{--                                                @foreach($arrCoupsCoeur[$indexLivre]->getAuteurs() as $auteur)--}}
{{--                                                    <li class="coupsCoeur__groupe__vignette__details__auteur">{{$auteur->getNomPrenom()}}</li>--}}
{{--                                                @endforeach--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="coupsCoeur__groupe__vignette__boutons">--}}
{{--                                    <h3 class="coupsCoeur__groupe__vignette__details__prix">{{$arrCoupsCoeur[$indexLivre]->prix}}$</h3>--}}
{{--                                    <a href="index.php?controleur=livre&action=fiche&isbn={{$arrCoupsCoeur[$indexLivre]->isbn}}" class="coupsCoeur__groupe__vignette__boutons__bouton_plus">EN SAVOIR PLUS</a>--}}
{{--                                    <a href="#" class="coupsCoeur__groupe__vignette__boutons__bouton_panier">AJOUTER AU PANIER</a>--}}
{{--                                    <a class="coupsCoeur__groupe__vignette__boutons__bouton_panier" href="index.php?controleur=livre&action=ajoutPanierAcccueil&isbn={{ $arrCoupsCoeur[$indexLivre] -> isbn }}">AJOUTER AU PANIER</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @endfor--}}
{{--                </div>--}}
{{--            </div>--}}

            <div class="row">
                @foreach($arrLivres as $livre)
                    <div class="catalogue__lesLivres col-md-6 col-lg-4">
                        <img src="{{ $livre -> getImageUrl("carre") }}" alt="Couverture du livre {{ $livre -> titre }}"
                             class="catalogue__couverture">
                        <div class="catalogue__livre">
                            <div class="catalogue__livre__titreEtAuteur">
                                <a class="catalogue__titre"
                                   href="index.php?controleur=livre&action=fiche&isbn={{ $livre -> isbn }}">{{ $livre -> titre }}</a>
                                <div class="row">
                                    @foreach($livre -> getAuteurs() as $auteur)
                                        <p class="catalogue__auteurs">{{ $auteur -> getNomPrenom() }}</p>
                                    @endforeach
                                </div>
                                <p class="catalogue__prix">{{$livre-> prix}}$</p>
                            </div>
                            <div class="catalogue__livre__boutons">
                                <a class="catalogue__btn catalogue__btn--enSavoirPlus" href="index.php?controleur=livre&action=fiche&isbn={{ $livre -> isbn }}">EN SAVOIR PLUS</a>
                                <a class="catalogue__btn catalogue__btn--ajouterPanier" href="index.php?controleur=livre&action=ajoutPanierCatalogue&isbn={{ $livre -> isbn }}">AJOUTER AU PANIER</a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            @include("livres.fragments.pagination")
        </div>
    </div>
    <script>
        function ouvrirFermerCategories() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        window.onclick = function (event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }

        }
    </script>
@endsection