@extends('gabarit')

@section("contenu")
    <div>
        <h3>Connexion</h3>
        <form action="index.php?controleur=compte&action=connecter" method="POST">
            <label for="email">Adresse courriel</label>
            <input type="email" name="email" id="email">
            <br>

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp">
            <br>

            <input type="submit" value="Se connecter">
        </form>
    </div>
@endsection

