<div class="content-pagination">
    <ul class="pagination info">

        <li class="item disabled">
            <span>Exibindo: {{ $paginator->count() }}</span>
        </li>

        <li class="item disabled">
            <span>de {{ $paginator->total() }}</span>
        </li>
    </ul>

    @if ($paginator->hasPages())
    <ul class="pagination">

        <li class="item {{ $paginator->onFirstPage() ? 'disabled' : '' }}">
            <a href="{{ $paginator->previousPageUrl() }}" class="link">
                <i class="fa-solid fa-angle-left"></i>
            </a>
        </li>

        @foreach ($elements as $element)
        @if (is_string($element))
        <li class="item disabled"><span>{{ $element }}</span></li>
        @endif

        @if (is_array($element))
        @foreach ($element as $page => $url)
        <li class="item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
            <a href="{{ $url }}" class="link">{{ $page }}</a>
        </li>
        @endforeach
        @endif
        @endforeach

        <li class="item {{ $paginator->hasMorePages() ? '' : 'disabled' }}">
            <a href="{{ $paginator->nextPageUrl() }}" class="link">
                <i class="fa-solid fa-angle-right"></i>
            </a>
        </li>
    </ul>
    @endif
</div>