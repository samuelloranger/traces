@extends('gabarit')

@section("contenu")
    <div class="inscription">
        <div class="inscription__formulaire bloc_formulaire">
            <h3 class="titre_formulaire">S'inscrire a Traces</h3>
            <form action="index.php?controleur=compte&action=inscrire" method="POST">
                {{-- PRENOM --}}
                <label for="prenom">Prenom</label>
                <input type="text" name="prenom" id="prenom"
                    @if(!$tValidation["formulaireValide"])
                        value="{{$tValidation["champs"]["prenom"]["valeur"]}}"
                        class="champ_formulaire champ_invalide"
                    @else
                       class="champ_formulaire"
                    @endif
                >
                @if(!$tValidation["champs"]["prenom"]["estValide"])
                    <p>{{$tValidation["champs"]["prenom"]["message"]}}</p>
                @endif

                {{-- NOM --}}
                <label for="nom">Nom</label>
                <input class="champ_formulaire" type="text" name="nom" id="nom"
                    @if(!$tValidation["formulaireValide"])
                        value="{{$tValidation["champs"]["nom"]["valeur"]}}"
                        class="champ_formulaire champ_invalide"
                    @else
                        class="champ_formulaire"
                    @endif
                >
                @if(!$tValidation["champs"]["nom"]["estValide"])
                    <p>{{$tValidation["champs"]["nom"]["message"]}}</p>
                @endif

                {{-- EMAIL --}}
                <label for="email">Courriel</label>
                <input class="champ_formulaire" type="email" name="email" id="email"
                    @if(!$tValidation["formulaireValide"])
                        value="{{$tValidation["champs"]["email"]["valeur"]}}"
                        class="champ_formulaire champ_invalide"
                    @else
                        class="champ_formulaire"
                    @endif
                >
                @if(!$tValidation["champs"]["email"]["estValide"])
                    <p>{{$tValidation["champs"]["email"]["message"]}}</p>
                @endif

                {{-- TELEPHONE --}}
                <label for="tel">Numero de telephone</label>
                <small class="inscription__formulaire__consignes">Ex: 418-999-9999</small>
                <input class="champ_formulaire" type="number" name="tel" id="tel"
                    @if(!$tValidation["formulaireValide"])
                        value="{{$tValidation["champs"]["tel"]["valeur"]}}"
                        class="champ_formulaire champ_invalide"
                    @else
                        class="champ_formulaire"
                    @endif
                >
                @if(!$tValidation["champs"]["tel"]["estValide"])
                    <p>{{$tValidation["champs"]["tel"]["message"]}}</p>
                @endif

                {{-- MOT DE PASSE --}}
                <label for="mdp">Mot de passe</label>
                <small class="inscription__formulaire__consignes">8 caracteres, lettres et chiffres, une majuscule.</small>
                <input class="champ_formulaire" type="password" name="mdp" id="mdp"
                    @if(!$tValidation["formulaireValide"])
                        value="{{$tValidation["champs"]["mdp"]["valeur"]}}"
                        class="champ_formulaire champ_invalide"
                    @else
                        class="champ_formulaire"
                    @endif
                >
                @if(!$tValidation["champs"]["mdp"]["estValide"])
                    <p>{{$tValidation["champs"]["mdp"]["message"]}}</p>
                @endif

                <div class="inscription__formulaire__afficher_mdp">
                    <input type="checkbox" name="afficher_mdp" id="afficher_mdp">
                    <label for="afficher_mdp"></label>
                    <span>Afficher le mot de passe</span>
                    <a class="inscription__formulaire__lien" href="#">Mot de passe oublie?</a>
                </div>

                {{-- CONFIRMATION MOT DE PASSE --}}
                <label for="c_mdp">Confirmer le mot de passe</label>
                <input class="champ_formulaire" type="password" name="c_mdp" id="c_mdp"
                    @if(!$tValidation["formulaireValide"])
                        value="{{$tValidation["champs"]["c_mdp"]["valeur"]}}"
                        class="champ_formulaire champ_invalide"
                    @else
                        class="champ_formulaire"
                    @endif
                >
                @if(!$tValidation["champs"]["c_mdp"]["estValide"])
                    <p>{{$tValidation["champs"]["c_mdp"]["message"]}}</p>
                @endif

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