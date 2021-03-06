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
    </head>
    <body>
        <header class="header" role="banner">
            @include('transaction.fragments.entete')
        </header>
        <div class="image">
            @yield("image_accueil")
        </div>
        <main class="container">
            @yield('contenu')
        </main>

        <footer class="footer container-fluid" role="contentinfo">
            @include('transaction.fragments.pieddepage')
        </footer>
    </body>
</html>




