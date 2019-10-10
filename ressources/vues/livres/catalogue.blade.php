@extends('gabarit')

@section('contenu')
    <main class="container col-12">
        <div class="row">
            <div class="row dropdown">
                <button onclick="ouvrirFermerCategories()" class="align-self-center dropbtn catalogue__btn--categories">
                    CATÉGORIES
                </button>
                <div id="myDropdown" class="dropdown-content">
                    <form method="post" action="{{$urlPagination}}">
                        <a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}"
                           class="catalogue__btn catalogue__btn--reinitialiser">RÉINITIALISER</a>
                        <ul class="catalogue__categories__liste">
                            @foreach($arrCategories as $categorie)
                                <li class="catalogue__categories__liste__item">
                                    <a href="index.php?controleur=livre&action=catalogue&categorie={{$categorie -> id}}&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}" class="catalogue__categories__lien">{{$categorie -> nom_fr}}</a>
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
                <a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}"
                   class="catalogue__btn catalogue__categories--reinitialiser">RÉINITIALISER</a>
                <ul class="catalogue__categories__liste">
                    @foreach($arrCategories as $categorie)
                        <li class="catalogue__categories__liste__item">
                            <a href="index.php?controleur=livre&action=catalogue&categorie={{$categorie -> id}}&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}" class="catalogue__categories__lien">{{$categorie -> nom_fr}}</a>
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
                           href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=9">9</a>
                        <a class="catalogue__lien"
                           href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=36">36</a>
                        <a class="catalogue__lien"
                           href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=72">72</a>
                    </div>
                </div>
                <div class="row catalogue__rangee--2">
                    {{--                    <p class="col-sm-12 col-md- catalogue__nbResultatsRecherche">*Nombre de livres trouvées*</p>--}}
                    <label for="catalogue__trier">Trier par :</label>
                    <select class="catalogue__trier" id="catalogue__trier" onchange=" location = this.value">
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
                <div class="catalogue__lesLivres row">
                    @foreach($arrLivres as $livre)
                        <img src="{{ $livre -> getImageUrl() }}" alt="Couverture du livre {{ $livre -> titre }}"
                             class="catalogue__couverture">
                        <div class="catalogue__livre">
                            <div class="catalogue__livre__titreEtAuteur">
                                <a class="catalogue__titre"
                                   href="index.php?controleur=livre&action=fiche&isbn={{ $livre -> isbn }}">{{ $livre -> titre }}</a>
                                @foreach($livre -> getAuteurs() as $auteur)
                                    <p class="catalogue__auteurs">{{ $auteur -> getNomPrenom() }}</p>
                                @endforeach
                                <p class="catalogue__prix">{{$livre-> prix}}$</p>
                            </div>
                            <div class="catalogue__livre__boutons"><a
                                        class="catalogue__btn catalogue__btn--enSavoirPlus"
                                        href="index.php?controleur=livre&action=fiche&isbn={{ $livre -> isbn }}">EN
                                    SAVOIR PLUS</a>
                                <a class="catalogue__btn catalogue__btn--ajouterPanier" href="">AJOUTER AU PANIER</a>
                            </div>

                        </div>
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