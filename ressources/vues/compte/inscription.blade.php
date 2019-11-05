@extends('gabarit')

@section("contenu")
    <div class="inscription">
        <div class="inscription__formulaire bloc_formulaire">
            <h3 class="titre_formulaire">S'inscrire a Traces</h3>
            <form action="index.php?controleur=compte&action=inscrire" method="POST">
                <label for="prenom">Prenom</label>
                <input class="champ_formulaire" type="text" name="prenom" id="prenom">
                <br>

                <label for="nom">Nom</label>
                <input class="champ_formulaire" type="text" name="nom" id="nom">
                <br>

                <label for="email">Courriel</label>
                <input class="champ_formulaire" type="email" name="email" id="email">
                <br>

                <label for="tel">Numero de telephone</label>
                <small class="inscription__formulaire__consignes">Ex: 418-999-9999</small>
                <input class="champ_formulaire" type="number" name="tel" id="tel">
                <br>

                <label for="mdp">Mot de passe</label>
                <small class="inscription__formulaire__consignes">8 caracteres, lettres et chiffres, une majuscule.</small>
                <input class="champ_formulaire" type="password" name="mdp" id="mdp">
                <br>

                <div class="inscription__formulaire__afficher_mdp">
                    <input type="checkbox" name="afficher_mdp" id="afficher_mdp">
                    <label for="afficher_mdp"></label>
                    <span>Afficher le mot de passe</span>
                    <a class="inscription__formulaire__lien" href="#">Mot de passe oublie?</a>
                </div>

                <label for="c_mdp">Confirmer le mot de passe</label>
                <input class="champ_formulaire" type="password" name="c_mdp" id="c_mdp">
                <br>

                <input class="bouton_panier" type="submit" value="S'inscrire">
            </form>
        </div>
        <div class="inscription__deja_client bloc_formulaire">
            <h4>Vous avez deja un compte?</h4>
            <a class="inscription__formulaire__lien" href="index.php?controleur=compte&action=connexion">Se connecter</a>
        </div>
        <div class="inscription__sans_compte bloc_formulaire">
            <a class="bouton inscription__formulaire__lien" href="#">Acheter sans creer de compte</a>
        </div>
    </div>
@endsection