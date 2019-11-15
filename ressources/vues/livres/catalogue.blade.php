@extends('gabarit')

@section('contenu')
    <div class="catalogue__filAriane">
        @include('fragments.filAriane')
    </div>
    <div class="catalogue__titre">
        <h1 class="catalogue__h1">Catalogue</h1>
    </div>
    @if($categorieActif !== "")
        <div class="catalogue__categories__actif">
            <h2 class="catalogue__categories__actif--h2">
                Catégorie : {{$categorieActif->nom_fr}}
            </h2>
        </div>
    @endif
    <div class="row">
        <div class="catalogue__categories col-lg-3">
            <p class="catalogue__categories__titre text-center">
                CATÉGORIES
            </p>
            <a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar={{$trierPar}}&nbParPages={{$livresParPage}}"
               class="catalogue__btn catalogue__categories--reinitialiser">RÉINITIALISER CATÉGORIE</a>
            <div class="catalogue__categories__contenu">
                <ul class="catalogue__categories__liste">
                    @foreach($arrCategories as $categorie)
                        <li class="catalogue__categories__liste__item">
                            <a href="index.php?controleur=livre&action=catalogue&categorie={{$categorie->id}}&trierPar={{$trierPar}}&nbParPages={{$livresParPage}}"
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
                    <div id="myDropdown" class="dropdown-content">
                        <form method="post" action="{{$urlPagination}}">
                            <a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar={{$trierPar}}&nbParPages={{$livresParPage}}"
                               class="catalogue__btn catalogue__btn--reinitialiser">RÉINITIALISER CATÉGORIE</a>
                            <ul class="catalogue__categories__liste">
                                @foreach($arrCategories as $categorie)
                                    <li class="catalogue__categories__liste__item">
                                        <a href="index.php?controleur=livre&action=catalogue&categorie={{$categorie->id}}&trierPar={{$trierPar}}&nbParPages={{$livresParPage}}"
                                           class="catalogue__categories__lien">{{$categorie -> nom_fr}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </form>
                    </div>
                </div>
                <div class="catalogue__alignementDesktop">
                    <div class="catalogue__trier">
                        <div class="catalogue__trier__alignement">
                            <p class="catalogue__trier__label">Trier par :</p>
                            <div class="catalogue__trier--select">
                                <select onchange="location = this.value">
                                    <option value="index.php?controleur=livre&action=catalogue&categorie={{$id_categorie}}&trierPar=aucun&nbParPages={{$livresParPage}}"
                                            @if($trierPar == 'aucun')
                                            selected
                                            @endif
                                    >Aucun
                                    </option>
                                    <option value="index.php?controleur=livre&action=catalogue&categorie={{$id_categorie}}&trierPar=alphabetique&nbParPages={{$livresParPage}}"
                                            @if($trierPar == 'alphabetique')
                                            selected

                                            @endif>Ordre alphabétique
                                    </option>
                                    <option value="index.php?controleur=livre&action=catalogue&categorie={{$id_categorie}}&trierPar=prixCroissant&nbParPages={{$livresParPage}}"
                                            @if($trierPar == 'prixCroissant')
                                            selected
                                            @endif>Prix: $ -> $$$
                                    </option>
                                    <option value="index.php?controleur=livre&action=catalogue&categorie={{$id_categorie}}&trierPar=prixDecroissant&nbParPages={{$livresParPage}}"
                                            @if($trierPar == 'prixDecroissant')
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
                        <a class="catalogue__lien 
                        @if($livresParPage == "9")
                                catalogue__lien--actif
                        @endif
                                "
                           href="index.php?controleur=livre&action=catalogue&categorie={{$id_categorie}}&trierPar={{$trierPar}}&nbParPages=9">9</a>
                        <a class="catalogue__lien
                         @if($livresParPage == "18")
                                catalogue__lien--actif
                            @endif
                                "
                           href="index.php?controleur=livre&action=catalogue&categorie={{$id_categorie}}&trierPar={{$trierPar}}&nbParPages=18">18</a>
                        <a class="catalogue__lien
                        @if($livresParPage == "36")
                                catalogue__lien--actif
                        @endif
                                "
                           href="index.php?controleur=livre&action=catalogue&categorie={{$id_categorie}}&trierPar={{$trierPar}}&nbParPages=36">36</a>
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
                                <a class="catalogue__titreLivre"
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
                                    <input type="hidden" name="redirection" value="catalogue&" hidden>
                                    <button class="catalogue__btn catalogue__btn--ajouterPanier catalogue__btn--ajouterPanierNoScript">
                                        AJOUTER AU PANIER
                                    </button>
                                    <button type="button"
                                            class="catalogue__btn catalogue__btn--ajouterPanier catalogue__btn--ajouterPanierScript"
                                            value="{{ $livre -> isbn }}">AJOUTER AU PANIER
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
