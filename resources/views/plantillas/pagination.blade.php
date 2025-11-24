@if ($paginator->hasPages())
    <ul class="myPagination">
        @if ($paginator->onFirstPage())
            <li class="myPageItem disabled"><span class="myPageLink">Anterior</span></li>
        @else
            <li class="myPageItem">
                <a href="{{ $paginator->previousPageUrl() }}" class="myPageLink">Anterior</a>
            </li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="myPageItem disabled"><span class="myPageLink">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="myPageItem active"><span class="myPageLink">{{ $page }}</span></li>
                    @else
                        <li class="myPageItem"><a class="myPageLink" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="myPageItem">
                <a href="{{ $paginator->nextPageUrl() }}" class="myPageLink">Siguiente</a>
            </li>
        @else
            <li class="myPageItem disabled"><span class="myPageLink">Siguiente</span></li>
        @endif
    </ul>
@endif