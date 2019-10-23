<p class="filAriane">
    @foreach($filAriane as $id => $lien)
        @if(isset($lien["lien"]))
            <a href="{{ $lien["lien"] }}">{{ $lien["titre"] }}</a>
        @else
            {{$lien["titre"]}}
        @endif

        @if($id !== 2)
            <span> > </span>
        @endif
    @endforeach
</p>