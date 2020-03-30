@if ($paginator->hasPages())
    <div class="pagination-layout1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="disabled btn-prev" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <a>
                    <span aria-hidden="true"><i class="fas fa-angle-double-right"></i>السابق</span>
                </a>
            </div>
        @else
            <div class="btn-prev">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><i class="fas fa-angle-double-right"></i>السابق</a>
            </div>
        @endif

        <div class="page-number">
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
                            <a class="active">{{ $page }}</a>
                        @else
                            <a href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <div class="btn-next">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">التالي<i class="fas fa-angle-double-left"></i></span>
                </a>
            </div>
        @else
            <div class="disabled btn-next">
                <a>
                    <span aria-hidden="true">التالي<i class="fas fa-angle-double-left"></i></span>
                </a>
            </div>
        @endif
    </div>
@endif
