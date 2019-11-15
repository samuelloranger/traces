@extends('gabarit')

@section("contenu")
    <div class="inscription">
        <div class="inscription__formulaire bloc_formulaire">
            <h3 class="titre_formulaire">S'inscrire a Traces</h3>
            <form action="index.php?controleur=compte&action=inscrire" method="POST">
                {{-- PRENOM --}}
                <div class="closestdiv">
                    <label for="prenom">Prenom</label>
                    <input type="text" name="prenom" id="prenom"
                           pattern="[a-zA-Z]{3,30}$"
                           @if(!$tValidation["formulaireValide"])
                           value="{{$tValidation["champs"]["prenom"]["valeur"]}}"
                           class="champ_formulaire js_inscription champ_invalide"
                           @else
                           class="champ_formulaire js_inscription"
                            @endif
                    >
                    <p id="retro-prenom">
                        @if(!$tValidation["champs"]["prenom"]["estValide"])
                            {{$tValidation["champs"]["prenom"]["message"]}}
                        @endif
                    </p>
                </div>


                {{-- NOM --}}
                <div class="closestdiv">
                    <label for="nom">Nom</label>
                    <input class="champ_formulaire js_inscription" type="text" name="nom" id="nom"
                           pattern="[a-zA-Z]{3,30}$"
                           @if(!$tValidation["formulaireValide"])
                           value="{{$tValidation["champs"]["nom"]["valeur"]}}"
                           class="champ_formulaire js_inscription champ_invalide"
                           @else
                           class="champ_formulaire js_inscription"
                            @endif
                    >
                    <p id="retro-nom">
                        @if(!$tValidation["champs"]["nom"]["estValide"])
                            {{$tValidation["champs"]["nom"]["message"]}}
                        @endif
                    </p>
                </div>


                {{-- EMAIL --}}
                <div class="closestdiv">
                    <label for="email">Courriel</label>
                    <input class="champ_formulaire js_inscription" type="email" name="email" id="email"
                           pattern="^[a-zA-Z0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[@][a-zA-Z0-9_-]+([.][a-zA-Z0-9_-]+)*[.][a-zA-Z]{2,}$"
                           @if(!$tValidation["formulaireValide"])
                           value="{{$tValidation["champs"]["email"]["valeur"]}}"
                           class="champ_formulaire js_inscription champ_invalide"
                           @else
                           class="champ_formulaire js_inscription"
                            @endif
                    >
                    <p id="retro-email">
                        @if(!$tValidation["champs"]["email"]["estValide"])
                            {{$tValidation["champs"]["email"]["message"]}}
                        @endif
                    </p>
                </div>


                {{-- TELEPHONE --}}
                <div class="closestdiv">
                    <label for="tel">Numero de telephone</label>
                    <small class="inscription__formulaire__consignes">Ex: 4186667777</small>
                    <input class="champ_formulaire js_inscription" type="number" name="tel" id="tel"
                           pattern="[0-9]{10}"
                           @if(!$tValidation["formulaireValide"])
                           value="{{$tValidation["champs"]["tel"]["valeur"]}}"
                           class="champ_formulaire js_inscription champ_invalide"
                           @else
                           class="champ_formulaire js_inscription"
                            @endif
                    >
                    <p id="retro-tel">
                        @if(!$tValidation["champs"]["tel"]["estValide"])
                            {{$tValidation["champs"]["tel"]["message"]}}
                        @endif
                    </p>
                </div>


                {{-- MOT DE PASSE --}}
                <div class="closestdiv">
                    <label for="mdp">Mot de passe</label>
                    <small class="inscription__formulaire__consignes">8 caracteres, lettres et chiffres, une majuscule.</small>
                    <input class="champ_formulaire js_inscription" type="password" name="mdp" id="mdp"
                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$"
                           @if(!$tValidation["formulaireValide"])
                           value="{{$tValidation["champs"]["mdp"]["valeur"]}}"
                           class="champ_formulaire js_inscription champ_invalide"
                           @else
                           class="champ_formulaire js_inscription"
                            @endif
                    >
                    <p id="retro-mdp">
                        @if(!$tValidation["champs"]["mdp"]["estValide"])
                            {{$tValidation["champs"]["mdp"]["message"]}}
                        @endif
                    </p>
                </div>


                <div class="inscription__formulaire__afficher_mdp">
                    <input class="toggle" type="checkbox" name="afficher_mdp" id="afficher_mdp">
                    <label for="afficher_mdp"></label>
                    <span>Afficher le mot de passe</span>
                    <a class="inscription__formulaire__lien" href="#">Mot de passe oublie?</a>
                </div>

                {{-- CONFIRMATION MOT DE PASSE --}}
                <div class="closestdiv">
                    <label for="c_mdp">Confirmer le mot de passe</label>
                    <input class="champ_formulaire js_inscription" type="password" name="c_mdp" id="c_mdp"
                           pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,15}$"
                           @if(!$tValidation["formulaireValide"])
                           value="{{$tValidation["champs"]["c_mdp"]["valeur"]}}"
                           class="champ_formulaire js_inscription champ_invalide"
                           @else
                           class="champ_formulaire js_inscription"
                            @endif
                    >
                    <p id="retro-c_mdp">
                        @if(!$tValidation["champs"]["c_mdp"]["estValide"])
                            {{$tValidation["champs"]["c_mdp"]["message"]}}
                        @endif
                    </p>

                </div>


                <input id="inscrire" class="bouton_panier" type="submit" value="S'inscrire">
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