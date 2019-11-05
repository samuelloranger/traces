<div class="conteneur-header">
    <nav class="navigation navigation__desktop">
        <div class="logoTraces">
            <a href="index.php?controleur=site&action=accueil">
                <img class="image" src="../public/liaisons/images/logo-traces.svg" alt="Logo librairie Traces">
            </a>
        </div>

        <div class="conteneurMenu">
            <ul class="conteneurMenu__menu">
                <li><a href="index.php?controleur=livre&action=catalogue">Catalogue</a></li>
                <li><a href="index.php?controleur=site&action=accueil#coupdecoeurs">Meilleurs vendeurs</a></li>
                <li><a href="index.php?controleur=auteurs&action=index">Auteurs</a></li>
                <li><a href="index.php?controleur=site&action=apropos">Découvrir Traces</a></li>
                <li><a href="index.php?controleur=site&action=index">Nous joindre</a></li>
                <li><a href="index.php?controleur=panier&action=panier" class="iconePanier" aria-label="Panier"><span aria-label="Panier" class="icone icone__panier"></span>@if(!$panierVide)<span class="nbrItemsPanier">{{ $nbrItemsPanier }}</span>@endif</a></li>
                <li>
                    <div role=”search”>
                        <span aria-label="Rechercher" class="icone icone__rechercher"></span>
                    </div>
                </li>
                <li class="btnSeConnecter"><a href="index.php?controleur=compte&action=connexion">Se connecter</a></li>
                <li><a href="index.php?controleur=compte&action=connexion">En</a></li>
            </ul>
        </div>
    </nav>


    <nav class="navigation navigation__mobile" aria-label="Navigation principale">
        <div class="navigation__mobile__top">
            <button class="hamburger hamburger--squeeze" type="button" id="btnMenuMobile">
              <span class="hamburger-box">
                <span class="hamburger-inner"></span>
              </span>
            </button>

            <div class="logoTraces">
                <a href="index.php?controleur=site&action=accueil">
                    <img class="image" src="../public/liaisons/images/logo-traces.svg" alt="Logo librairie Traces">
                </a>
            </div>

            <div class="zoneIcones">
                <a href="index.php?controleur=panier&action=panier" class="iconePanier icone icone__panier">@if(!$panierVide)<span class="nbrItemsPanier">{{ $nbrItemsPanier }}</span>@endif</a>
                <span class="icone icone__rechercher"></span>
            </div>

            <span class="zoneLangue zoneLangue--inactif"><a href="index.php?controleur=accueil&action=index">EN</a></span>
        </div>

        <div class="navigation__mobile__menu navigation__mobile__menu--ferme">
            <h2>Menu</h2>
            <ul class="conteneurMenu__menu">
                <li><a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar=aucun&nbParPages=9">Catalogue</a></li>
                <li><a href="index.php?controleur=site&action=accueil#meilleurs-vendeurs">Meilleurs vendeurs</a></li>
                <li><a href="index.php?controleur=auteurs&action=index">Auteurs</a></li>
                <li><a href="index.php?controleur=site&action=apropos">Découvrir Traces</a></li>
                <li><a href="index.php?controleur=site&action=index">Nous joindre</a></li>
                <li class="btnSeConnecter"><a href="index.php?controleur=compte&action=connexion">Se connecter</a></li>
            </ul>
        </div>
    </nav>

    <div class="modaleItemAjoute modaleItemAjoute--inactive">
        <div class="modaleItemAjouteConteneur">

            <div class="modaleItemAjoute__conteneurBouton">
                <p class="titreFenetreModale h4">L'item a ajouté au panier!</p>

                <button class="hamburger hamburger--squeeze is-active" type="button" id="btnFermerFenetreModale">
                  <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                  </span>
                </button>
            </div>

            <div class="modaleItemAjoute__infosLivre">
                <img class="image" src="" alt="Vignette">
                <div class="infos">
                    <p class="infos__titre h4"></p>
                    <p class="infos__prix"></p>
                </div>
            </div>

            <div class="modaleItemAjoute__infosPanier">
                <p class="h4">Panier</p>
                <p><strong>Total:</strong> <span class="sous-total"></span></p>

                <a href="index.php?controleur=panier&action=panier" class="bouton" type="button">Voir le panier</a>
            </div>

        </div>
    </div>
</div>



