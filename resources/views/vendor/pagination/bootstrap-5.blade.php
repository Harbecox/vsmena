@if ($paginator->hasPages())
    <div class="position-relative d-flex justify-content-center w-100">
        <div class="d-flex gap-20">
            @if(!$paginator->onFirstPage())
                <a href="{{ $paginator->previousPageUrl() }}" class="btn-primary btn d-flex align-items-center gap-10">
                    <x-icon name="arrow_left"/>Предыдущая страница
                </a>
            @endif
            @if(!$paginator->onLastPage())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn-primary btn d-flex align-items-center gap-10">Следующая страница
                    <x-icon name="arrow_right"/>
                </a>
            @endif
        </div>
        <div class="position-absolute fs-14 d-flex gap-15 align-items-center" style="right: 0">
            Страница
{{--            <span style="border-radius: 8px;padding: 12px 24px;background-color: #fff">{{ $paginator->currentPage() }}</span>--}}
            <form method="GET" action="{{ url()->current() }}" class="d-flex align-items-center gap-10" id="pageJumpForm">
                @foreach(request()->except('page') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <input
                    name="page"
                    value="{{ $paginator->currentPage() }}"
                    class="page-jump-input"
                    style="width: 53px;text-align: center; border-radius: 8px; padding: 12px 0; background-color: #fff; border: 1px solid #ccc;"
                >
            </form>
            из {{ $paginator->lastPage() }}
        </div>
    </div>

    <script>
        document.querySelector('.page-jump-input').addEventListener('change', function () {
            const maxPage = {{ $paginator->lastPage() }};
            let page = parseInt(this.value);
            if (page < 1) page = 1;
            if (page > maxPage) page = maxPage;

            const form = document.getElementById('pageJumpForm');
            const input = form.querySelector('input[name="page"]');
            input.value = page;
            input.addEventListener('focus', function () {
                this.select();
            });
            form.submit();
        });
    </script>


    {{--    <nav class="d-flex justify-items-center justify-content-between">--}}
    {{--        <div class="d-flex justify-content-between flex-fill d-sm-none">--}}
    {{--            <ul class="pagination">--}}
    {{--                --}}{{-- Previous Page Link --}}
    {{--                @if ($paginator->onFirstPage())--}}
    {{--                    <li class="page-item disabled" aria-disabled="true">--}}
    {{--                        <span class="page-link">@lang('pagination.previous')</span>--}}
    {{--                    </li>--}}
    {{--                @else--}}
    {{--                    <li class="page-item">--}}
    {{--                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>--}}
    {{--                    </li>--}}
    {{--                @endif--}}

    {{--                --}}{{-- Next Page Link --}}
    {{--                @if ($paginator->hasMorePages())--}}
    {{--                    <li class="page-item">--}}
    {{--                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>--}}
    {{--                    </li>--}}
    {{--                @else--}}
    {{--                    <li class="page-item disabled" aria-disabled="true">--}}
    {{--                        <span class="page-link">@lang('pagination.next')</span>--}}
    {{--                    </li>--}}
    {{--                @endif--}}
    {{--            </ul>--}}
    {{--        </div>--}}

    {{--        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">--}}
    {{--            <div>--}}
    {{--                <p class="small text-muted">--}}
    {{--                    {!! __('Showing') !!}--}}
    {{--                    <span class="fw-semibold">{{ $paginator->firstItem() }}</span>--}}
    {{--                    {!! __('to') !!}--}}
    {{--                    <span class="fw-semibold">{{ $paginator->lastItem() }}</span>--}}
    {{--                    {!! __('of') !!}--}}
    {{--                    <span class="fw-semibold">{{ $paginator->total() }}</span>--}}
    {{--                    {!! __('results') !!}--}}
    {{--                </p>--}}
    {{--            </div>--}}

    {{--            <div>--}}
    {{--                <ul class="pagination">--}}
    {{--                    --}}{{-- Previous Page Link --}}
    {{--                    @if ($paginator->onFirstPage())--}}
    {{--                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">--}}
    {{--                            <span class="page-link" aria-hidden="true">&lsaquo;</span>--}}
    {{--                        </li>--}}
    {{--                    @else--}}
    {{--                        <li class="page-item">--}}
    {{--                            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">&lsaquo;</a>--}}
    {{--                        </li>--}}
    {{--                    @endif--}}

    {{--                    --}}{{-- Pagination Elements --}}
    {{--                    @foreach ($elements as $element)--}}
    {{--                        --}}{{-- "Three Dots" Separator --}}
    {{--                        @if (is_string($element))--}}
    {{--                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>--}}
    {{--                        @endif--}}

    {{--                        --}}{{-- Array Of Links --}}
    {{--                        @if (is_array($element))--}}
    {{--                            @foreach ($element as $page => $url)--}}
    {{--                                @if ($page == $paginator->currentPage())--}}
    {{--                                    <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>--}}
    {{--                                @else--}}
    {{--                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>--}}
    {{--                                @endif--}}
    {{--                            @endforeach--}}
    {{--                        @endif--}}
    {{--                    @endforeach--}}

    {{--                    --}}{{-- Next Page Link --}}
    {{--                    @if ($paginator->hasMorePages())--}}
    {{--                        <li class="page-item">--}}
    {{--                            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">&rsaquo;</a>--}}
    {{--                        </li>--}}
    {{--                    @else--}}
    {{--                        <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">--}}
    {{--                            <span class="page-link" aria-hidden="true">&rsaquo;</span>--}}
    {{--                        </li>--}}
    {{--                    @endif--}}
    {{--                </ul>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </nav>--}}
@endif
