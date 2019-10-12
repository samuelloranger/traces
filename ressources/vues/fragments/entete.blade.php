<div class="conteneur-header">
    <nav class="navigation navigation__desktop">
        <div class="logoTraces">
            <a href="index.php?controleur=site&action=accueil">
                <img class="image" src="../public/liaisons/images/logo-traces.svg" alt="Logo librairie Traces">
            </a>
        </div>

        <div class="conteneurMenu">
            <ul class="conteneurMenu__menu">
                <li><a href="index.php?controleur=livre&action=catalogue&categorie=0&trierPar=aucun&nbParPages=9">Catalogue</a></li>
                <li><a href="index.php?controleur=site&action=accueil#meilleurs-vendeurs">Meilleurs vendeurs</a></li>
                <li><a href="index.php?controleur=auteurs&action=index">Auteurs</a></li>
                <li><a href="index.php?controleur=site&action=apropos">Découvrir Traces</a></li>
                <li><a href="index.php?controleur=site&action=index">Nous joindre</a></li>
                <li><a aria-label="Panier" href="index.php?controleur=panier&action=panier"><span aria-label="Panier" class="icone icone__panier"></span></a></li>
                <li><span aria-label="Rechercher" class="icone icone__rechercher"></span></li>
                <li class="btnSeConnecter"><a href="index.php?controleur=accueil&action=index">Se connecter</a></li>
                <li><a href="index.php?controleur=accueil&action=index">En</a></li>
            </ul>
        </div>
    </nav>


    <nav class="navigation navigation__mobile">
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
                <span class="icone icone__panier"><a href="index.php?controleur=livre&action=index"></a></span>
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
                <li class="btnSeConnecter"><a href="index.php?controleur=accueil&action=index">Se connecter</a></li>
            </ul>
        </div>
    </nav>
</div>



