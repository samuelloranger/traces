<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Librairie Traces</title>
        <link rel="stylesheet" type="text/css" href="./liaisons/css/styles.css">
        <link rel="stylesheet" type="text/css" href="./liaisons/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    </head>
    <body>
        <header class="header">
            @include('fragments.entete')
        </header>

        <main>
            @yield('contenu')
        </main>

        <footer class="footer">
            @include('fragments.pieddepage')
        </footer>
    </body>
</html>




