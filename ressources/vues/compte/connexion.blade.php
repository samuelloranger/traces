@extends('gabarit')

@section("contenu")
    <div>
        <h3>Connectez-vous</h3>
        <form action="index.php?controleur=compte&action=connecter" method="POST">
            <label for="email">Adresse courriel</label>
            <input type="email" name="email" id="email">
            <br>

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp">
            <br>



            <div>
                <input type="checkbox" name="afficher_mdp" id="afficher_mdp">
                <label for="afficher_mdp">Afficher le mot de passe</label>
                <a href="#">Mot de passe oublie?</a>
            </div>

            <div>
                <input type="submit" value="Se connecter">
            </div>
        </form>
    </div>
    <div>
        <h4>Vous n'avez pas de compte?</h4>
        <a href="index.php?controleur=compte&action=inscription">Se creer un compte</a>
    </div>
    <div>
        <a href="#">Acheter sans creer de compte</a>
    </div>
@endsection

