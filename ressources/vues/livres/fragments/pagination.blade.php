

    <!-- Si on est pas sur la première page et s'il y a plus d'une page -->
    @if ($numeroPage > 1)
        <a href= "{!! $urlPagination . "&page=" . 1  !!}">Premier</a>
    @else
        <span style="color:#999">Premier</span>
    @endif

    &nbsp;|&nbsp;

    @if ($numeroPage > 1)
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) - 1) !!}">Précédent</a>
    @else
        <span style="color:#999">Précédent</span>
    @endif

    &nbsp;|&nbsp;

    {{"Page " . ($numeroPage) . " de " . ($nombreTotalPages)}}

    &nbsp;|&nbsp;

    @if ($numeroPage < $nombreTotalPages)
        <a href="{!! $urlPagination . "&page=" . (htmlspecialchars($numeroPage) + 1)  !!}">Suivant</a>
    @else
        <span style="color:#999">Suivant</span>
    @endif

    &nbsp;|&nbsp;

    @if ($numeroPage < $nombreTotalPages)
        <a href="{!! $urlPagination . "&page=" . htmlspecialchars($nombreTotalPages) !!}">Dernier</a>
    @else
        <span style="color:#999">Dernier</span>
    @endif



