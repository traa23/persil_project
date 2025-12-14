@if ($paginator->hasPages())
    <nav style="display: flex; justify-content: center; gap: 0.5em; flex-wrap: wrap;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span style="padding: 0.5em 1em; background: #ccc; color: #666; border-radius: 3px;">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="padding: 0.5em 1em; background: #2ebaae; color: white; border-radius: 3px; text-decoration: none;">Previous</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 0.5em 1em;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 0.5em 1em; background: #2ebaae; color: white; border-radius: 3px; font-weight: bold;">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="padding: 0.5em 1em; background: #f0f0f0; color: #333; border-radius: 3px; text-decoration: none;">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="padding: 0.5em 1em; background: #2ebaae; color: white; border-radius: 3px; text-decoration: none;">Next</a>
        @else
            <span style="padding: 0.5em 1em; background: #ccc; color: #666; border-radius: 3px;">Next</span>
        @endif
    </nav>
@endif
