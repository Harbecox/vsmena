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


@endif
