@extends('gabarit')

@section('contenu')
    @include('fragments.filAriane')

    <div class="row">

        <div class="catalogue__categories col-lg-3">
            <p class="catalogue__categories__titre text-center">
                CATÉGORIES
            </p>
            <a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar={{$_GET['trierPar']}}&nbParPages={{ $_GET['nbParPages'] }}"
               class="catalogue__btn catalogue__categories--reinitialiser">RÉINITIALISER</a>
            <div class="catalogue__categories__contenu">
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

                <div class="catalogue__alignementDesktop">
                    <input type="text" class="catalogue__rechercher">
                    <input type="submit" class="catalogue__rechercher catalogue__rechercher__bouton" value="Rechercher">
                    <div class="catalogue__trier">
                        <div class="catalogue__trier__alignement">
                            <p class="catalogue__trier__label">Trier par :</p>
                            <div class="catalogue__trier--select">
                                <select onchange="location = this.value">
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
                            </div>

                        </div>
                    </div>
                </div>
                <div class="catalogue__alignementDesktop">
                    <div class="catalogue__trier__alignement">
                        <p class="catalogue__nbParPages__label">Nombre de livres par pages :</p>
                        <a class="catalogue__lien"
                           href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=9">9</a>
                        <a class="catalogue__lien"
                           href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=18">18</a>
                        <a class="catalogue__lien"
                           href="index.php?controleur=livre&action=catalogue&categorie={{$_GET['categorie']}}&trierPar={{$_GET['trierPar']}}&nbParPages=36">36</a>
                    </div>
                    <div class="catalogue__nbResultats">
                        <p>Nombre de résultats : <b>{{$nbResultats}}</b></p>
                    </div>
                </div>

            </div>

            <div class="catalogue__pagination">
                @include("livres.fragments.pagination")
            </div>
            <div class="row">
                @foreach($arrLivres as $livre)
                    <div class="catalogue__lesLivres col-md-6 col-lg-4">
                        <div class="catalogue__foreground "></div>
                        <img src="{{ $livre -> getImageUrl("carre") }}" alt="Couverture du livre {{ $livre -> titre }}"
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
                            <div class="catalogue__livre__boutons">
                                <a class="catalogue__btn catalogue__btn--enSavoirPlus"
                                   href="index.php?controleur=livre&action=fiche&isbn={{ $livre -> isbn }}">EN SAVOIR
                                    PLUS</a>
                                <form action="index.php?controleur=panier&action=ajoutPanier&redirection=catalogue&isbn={{ $livre -> isbn }}"
                                      method="POST" class="catalogue__btn--form">
                                    <input type="hidden" name="isbn" value="{{ $livre -> isbn }}" hidden>
                                    <input type="hidden" name="controleur" value="panier" hidden>
                                    <input type="hidden" name="action" value="ajoutPanier" hidden>
                                    <input type="hidden" name="qte" value="1" hidden>
                                    <input type="hidden" name="redirection" value="catalogue" hidden>
                                    <button class="catalogue__btn catalogue__btn--ajouterPanier">AJOUTER AU PANIER
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="catalogue__pagination">
                @include("livres.fragments.pagination")
            </div>

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
