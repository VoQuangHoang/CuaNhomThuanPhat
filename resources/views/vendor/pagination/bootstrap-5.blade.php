@if ($paginator->hasPages())
   
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="prev page-numbers disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <i class="far fa-chevron-left" aria-hidden="true"></i>
                </a>
            @else
                <a class="prev page-numbers" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    <i class="far fa-chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page-numbers current" aria-current="page">{{ $page }}</span>
                        @elseif ($page == 1 || $page == $paginator->currentPage() + 1 || $page == $paginator->currentPage() - 1 || $page == $paginator->lastPage())
                             <a href="{{ $url }}" class="page-numbers">{{ $page }}</a>
                        @elseif ($page == $paginator->lastPage() - 1 || $page == 2)
                            <span class="page-numbers">...</span>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="next page-numbers" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    <i class="far fa-chevron-right"></i>
                </a>
            @else
                <a class="next page-numbers" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <i class="far fa-chevron-right" aria-hidden="true"></i>
                </a>
            @endif
       
    
@endif
