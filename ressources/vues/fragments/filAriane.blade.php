<p class="filAriane">
    @foreach($filAriane as $id => $lien)
        @if(isset($lien["lien"]))
            <a href="{{ $lien["lien"] }}">{{ $lien["titre"] }}</a>
        @else
            {{$lien["titre"]}}
        @endif

        @if((count($filAriane) === 4) && $id !== 3 || (count($filAriane) == 3 && $id !== 3) || (count($filAriane) == 2) && $id !== 1)
            <span> > </span>
        @endif
    @endforeach
</p>