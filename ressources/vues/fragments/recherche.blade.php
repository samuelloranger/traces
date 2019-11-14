    @if(isset($arrRecherche))
        <div>
            <ul>
                @foreach($arrRecherche as $resultat)
                    <li>
                        <a href="#">{{ $resultat -> titre }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif