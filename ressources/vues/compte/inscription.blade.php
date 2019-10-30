@extends('gabarit')

@section("contenu")
    <div>
        <h3>Ceci est la page d'inscription</h3>
        <form action="index.php?controleur=compte&action=inscrire" method="POST">
            <label for="prenom">Prenom</label>
            <input type="text" name="prenom" id="prenom">
            <br>

            <label for="nom">Nom</label>
            <input type="text" name="nom" id="nom">
            <br>

            <label for="email">Courriel</label>
            <input type="email" name="email" id="email">
            <br>

            <label for="tel">Numero de telephone</label>
            <input type="number" name="tel" id="tel">
            <br>

            <label for="mdp">Mot de passe</label>
            <input type="password" name="mdp" id="mdp">
            <br>

            <label for="c_mdp">Confirmer le mot de passe</label>
            <input type="password" name="c_mdp" id="c_mdp">
            <br>

            <input class="bouton_panier" type="submit" value="S'inscrire">
        </form>
    </div>
@endsection