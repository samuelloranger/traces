<!DOCTYPE html>

<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Librairie Traces">
        <meta name="keywords" content="Librarie, Traces, livres, lecture, histoire, historique">
        <meta name="author" content="Samuel Loranger, Olivier Papineau, Zachary Nicol">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Librairie Traces</title>
        <link rel="stylesheet" type="text/css" href="./liaisons/css/styles.css">
        <link rel="stylesheet" type="text/css" href="./liaisons/bootstrap-4.3.1-dist/css/bootstrap.min.css">

        {{--    Icône d'application     --}}
        <link rel="apple-touch-icon" sizes="180x180" href="liaisons/images/icones/favicon/apple-touch-icon.png">
        <link rel="icon" type="image/png" sizes="32x32" href="liaisons/images/icones/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="16x16" href="liaisons/images/icones/favicon/favicon-16x16.png">
        <link rel="manifest" href="liaisons/images/icones/favicon/site.webmanifest">
        <link rel="mask-icon" href="liaisons/images/icones/favicon/safari-pinned-tab.svg" color="#5bbad5">
        <link rel="shortcut icon" href="liaisons/images/icones/favicon/favicon.ico">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-config" content="liaisons/images/icones/favicon/browserconfig.xml">
        <meta name="theme-color" content="#ffffff">
    </head>
    <body>
        <header class="header" role="banner">
            @include('fragments.entete')
        </header>
        <div class="image">
            @yield("image_accueil")
        </div>
        <main class="container">
            @yield('contenu')
        </main>

        <footer class="footer container-fluid" role="contentinfo">
            @include('fragments.pieddepage')
        </footer>
    </body>
</html>




