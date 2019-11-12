@extends('gabarit')

@section("contenu")
    <div class="connexion">
        <div class="connexion__formulaire bloc_formulaire">
            <h3 class="titre_formulaire">Connectez-vous</h3>
            <form action="index.php?controleur=compte&action=connecter" method="POST">
                <label for="email">Adresse courriel</label>
                <input type="email" name="email" id="email"
                    pattern="^[a-zA-Z0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,}$"
                    @if(!$tValidation["formulaireValide"])
                        value="{{$tValidation["champs"]["email"]["valeur"]}}"
                        class="champ_formulaire js_connexion champ_invalide"
                    @else
                        class="champ_formulaire js_connexion"
                    @endif
                >
                <p id="retro-email">
                    @if(!$tValidation["champs"]["email"]["estValide"])
                        {{$tValidation["champs"]["email"]["message"]}}
                    @endif
                </p>
                <br>

                <label for="mdp">Mot de passe</label>
                <input class="champ_formulaire js_connexion" type="password" name="mdp" id="mdp"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$"
                    @if(!$tValidation["formulaireValide"])
                        value="{{$tValidation["champs"]["mdp"]["valeur"]}}"
                        class="champ_formulaire js_connexion champ_invalide"
                    @else
                        class="champ_formulaire js_connexion"
                    @endif
                >
                <p id="retro-mdp">
                    @if(!$tValidation["champs"]["mdp"]["estValide"])
                        {{$tValidation["champs"]["mdp"]["message"]}}
                    @endif
                </p>
                <br>

                <div class="connexion__formulaire__afficher_mdp">
                    <input class="toggle" type="checkbox" name="afficher_mdp" id="afficher_mdp">
                    <label for="afficher_mdp"></label>
                    <span>Afficher le mot de passe</span>
                    <a class="connexion__formulaire__lien" href="#">Mot de passe oublie?</a>
                </div>

                <div>
                    <input id="connecter" class="bouton bouton_panier" type="submit" value="Se connecter">
                </div>
            </form>
        </div>
        <div class="connexion__pas_client bloc_formulaire">
            <h4>Vous n'avez pas de compte?</h4>
            <a class="connexion__formulaire__lien" href="index.php?controleur=compte&action=inscription">Se creer un compte</a>
        </div>
        <div class="connexion__sans_compte bloc_formulaire">
            <a class="connexion__formulaire__lien" href="#">Acheter sans creer de compte</a>
        </div>
    </div>

@endsection

