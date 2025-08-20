{{--@php--}}
{{--    $result = [];--}}
{{--    $elements = array_values($elements);--}}
{{--    dd($elements);--}}
{{--    if (count($elements) === 1 && is_array($elements[0])) {--}}
{{--        $result = array_slice($elements[0], 0, 6);--}}
{{--    } elseif (count($elements) === 3 && is_array($elements[0]) && is_string($elements[1]) && is_array($elements[2])) {--}}
{{--        $result = array_merge(--}}
{{--            array_slice($elements[0], 0, 3),--}}
{{--            [$elements[1]],--}}
{{--            array_slice($elements[2], -2)--}}
{{--        );--}}
{{--    }--}}

{{--    $elements = $result;--}}
{{--@endphp--}}

@if ($paginator->hasPages())

    <div class="position-relative d-lg-flex d-none justify-content-center w-100">
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
    <div class="d-flex d-lg-none">
        @if($paginator->count() > 1)
            <div class="pagination_mobile">
                @if($paginator->onFirstPage())
                    <div class="page_item disabled">
                        <x-icon name="pagination_prev" />
                    </div>
                @else
                    <div class="page_item">
                        <a href="{{ $paginator->previousPageUrl() }}">
                            <x-icon name="pagination_prev" />
                        </a>
                    </div>
                @endif

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <div class="page_item">{{ $element }}</div>
                    @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <div class="page_item active">{{ $page }}</div>
                                @else
                                    <div class="page_item"><a href="{{ $url }}">{{ $page }}</a></div>
                                @endif
                            @endforeach
                        @endif
                @endforeach
                    @if($paginator->hasMorePages())
                        <div class="page_item">
                            <a href="{{ $paginator->nextPageUrl() }}">
                                <x-icon name="pagination_next" />
                            </a>
                        </div>
                    @else
                        <div class="page_item disabled">
                            <x-icon name="pagination_next" />
                        </div>
                    @endif

            </div>
        @endif
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


@endif
