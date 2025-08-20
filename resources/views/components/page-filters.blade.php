<div class="d-flex flex-column gap-20 filters_wrapper">
    <div class="filters d-flex gap-20">
        @foreach($filters as $filter)
            {!! $filter->render() !!}
        @endforeach
        @if($exportUrl)
            <div class="filter d-flex align-items-center">
                <a href="{{ $exportUrl }}">
                    <x-icon name="export"/>
                </a>
            </div>
        @endif
    </div>
    <div class="d-none d-xl-flex justify-content-end">
        <button class="btn btn-light clear_filter">Сбросить фильтры</button>
    </div>
</div>
