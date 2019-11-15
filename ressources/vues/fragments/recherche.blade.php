    @if(isset($arrRecherche))
        <div>
            <ul>
                @foreach($arrRecherche as $resultat)
                    <li>
                        <a href="index.php?controleur=livre&action=fiche&isbn={{ $resultat -> isbn }}">{{ $resultat -> titre }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif