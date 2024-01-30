@if ($paginator->hasPages())
<div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="pagination pagi1">
            <ul>
                <li>

                    @if ($paginator->onFirstPage())
                        <a class="disabled" aria-disabled="true" aria-label="@lang('pagination.previous')"> <i class="fa fa-arrow-left"></i> </a>
                    @else
                        <a class="" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"> <i class="fa fa-arrow-left"></i> </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <a class=" disabled" aria-disabled="true">{{ $element }}</a>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <a class=" is-active" href="{{ $url }}" aria-current="page">{{ $page }}</a>
                                @else
                                    <a class="" href="{{ $url }}">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a class="" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')"> <i class="fa fa-arrow-right"></i> </a>
                    @else
                        <a class=" disabled" aria-disabled="true" aria-label="@lang('pagination.next')"> <i class="fa fa-arrow-right"></i> </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>
@endif
