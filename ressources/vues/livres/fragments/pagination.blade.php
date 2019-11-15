<!-- Si on est pas sur la première page et s'il y a plus d'une page -->
@if ($numeroPage > 1)
    <a class="catalogue__pagination__premierDernier" href="{!! $urlPagination . "&page=" . 1  !!}">Premier</a>
@else
    <span class="catalogue__pagination__premierDernier" style="color:#999">Premier</span>
@endif

&nbsp;|&nbsp;

@if ($numeroPage > 1)
    <a class="catalogue__pagination__fleche"
       href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) - 1) !!}">⇦</a>
@else
    <span class="catalogue__pagination__fleche" style="color:#999">⇦</span>
@endif

<p class="catalogue__pagination__numeroPage"><b>{{$numeroPage}}</b>  de  <b>{{$nombreTotalPages}}</b></p>

@if ($numeroPage < $nombreTotalPages)
    <a class="catalogue__pagination__fleche"
       href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) + 1)  !!}">⇨</a>
@else
    <span class="catalogue__pagination__fleche" style="color:#999">⇨</span>
@endif

&nbsp;|&nbsp;

@if ($numeroPage < $nombreTotalPages)
    <a class="catalogue__pagination__premierDernier" href="{!! $urlPagination . "&page=" . htmlspecialchars($nombreTotalPages) !!}">Dernier</a>
@else
    <span class="catalogue__pagination__premierDernier" style="color:#999">Dernier</span>
@endif



