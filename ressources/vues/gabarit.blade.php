<html lang="fr">
    <head>
        <meta charset="utf-8">
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




