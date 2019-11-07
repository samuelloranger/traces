<h2>Commentaires de lecteurs</h2>
<div class="commentaire">
    <h3>Adoré ce livre!</h3>
    <p class="auteur">Samuel Loranger</p>
    <div class="zoneEtoiles zoneEtoiles4"></div>
    <p>Superbe livre ! Un peu dur à comprendre par bouts, mais j’ai adoré ma lecture. J'étais réellement plongé dans l'histoire !</p>
    <p><span class="achatVerif">Achat vérifié</span></p>
</div>

<div class="commentaire">
    <h3>Adoré ce livre!</h3>
    <p class="auteur">Zachary Nicol</p>
    <div class="zoneEtoiles zoneEtoiles5"></div>
    <p>Superbe livre ! Un peu dur à comprendre par bouts, mais j’ai adoré ma lecture. J'étais réellement plongé dans l'histoire !</p>
    <p><span class="achatVerif">Achat vérifié</span></p>
</div>

@foreach($arrCommentaires as $commentaire)
    <div class="commentaire">
        <h3>{{ $commentaire -> __get("titre_commentaire") }}</h3>
        <p class="auteur">{{ $commentaire -> __get("prenom")}} {{ $commentaire -> __get("nom")  }}</p>
        <div class="zoneEtoiles zoneEtoiles{{ $commentaire -> __get("cote") }}"></div>
        <p>{{ $commentaire -> __get("texte_commentaire") }}</p>
        @if($commentaire -> __get("achat_verifie"))
            <p><span class="achatVerif">Achat vérifié</span></p>
        @endif
    </div>
@endforeach

<h2>Écrire un commentaire</h2>

<form class="formulaireNouveauCommentaire" method="post" action="index.php?controleur=livre&action=ajouterCommentaire">
    @if($estConnecte == false)
        <p class="messageConnection">Vous devez être <a href="index.php?controleur=compte&action=connexion">conecté</a> pour pouvoir écrire un commentaire</p>
    @endif

    <input type="hidden" id="isbn" name="isbn" class="isbn elementFormCommentaire" value="{{ $livre->isbn }}">
    <input type="hidden" id="idClient" name="idClient" class="idClient elementFormCommentaire" value="{{ $idClient }}" >

    <div class="conteneurElemForm">
        <label for="titre_commentaire">Titre du commentaire</label>
        <small>Donnez un titre à votre commentaire</small>
        <input type="text" id="titre_commentaire" class="titre_commentaire elementFormCommentaire" name="titre_commentaire" @if($estConnecte == false) disabled @endif/>
        @if(isset($arrErreurs["titre_commentaire"]))
            <p class="erreur erreur--icone">{{ $arrErreurs["titre_commentaire"] }}</p>
        @else
            <p class="erreur"></p>
        @endif

    </div>

    <div class="conteneurElemForm">
        <label for="texte_commentaire">Texte du commentaire</label>
        <small>50 caractères minimum, 255 caractères maximum</small>
        <small>Caractères restants: <span class="caracteresRestants">255</span></small>
        <textarea rows="4" cols="50" maxlength="255" id="texte_commentaire" class="texte_commentaire elementFormCommentaire" name="texte_commentaire" @if($estConnecte == false) disabled @endif></textarea>
        @if(isset($arrErreurs["texte_commentaire"]))
            <p class="erreur erreur--icone">{{ $arrErreurs["texte_commentaire"] }}</p>
        @else
            <p class="erreur"></p>
        @endif

    </div>

    <div class="conteneurElemForm">
        <label for="cote">Cote</label>
        <small>Donnez une note sur 5 sur le livre</small>
        <input type="number" id="cote" class="cote elementFormCommentaire" name="cote" maxlength="1" min="1" max="5" value="" @if($estConnecte == false) disabled @endif/>
        <p class="erreur"></p>
        @if(isset($arrErreurs["cote"]))
            <p class="erreur erreur--icone">{{ $arrErreurs["cote"] }}</p>
        @else
            <p class="erreur"></p>
        @endif
    </div>

    <div class="conteneurElemForm">
        <div class="zoneConfirmationAchat">
            <label for="achatVerif">J'ai acheté ce livre</label>
            <input type="checkbox" id="achatVerif" value="verifie" class="achatVerif elementFormCommentaire elementFormCommentaire--nonObligatoire" name="achatVerif" @if($estConnecte == false) disabled @endif/>
        </div>
    </div>

    <button class="boutonEnvoyerCommentaire boutonEnvoyerCommentaireNoScript">Envoyer</button>
    <button type="button" class="boutonEnvoyerCommentaire boutonEnvoyerCommentaireScript" disabled="disabled">Envoyer</button>
</form>