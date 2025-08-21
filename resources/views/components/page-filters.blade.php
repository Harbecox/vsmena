@php

    $hasFilter = false;
    $params = request()->all();
    if(!empty($params)){
        foreach ($filters as $filter){
            if(request()->has($filter->name)){
                $hasFilter = true;
                break;
            }
        }
    }


@endphp

<div class="d-flex flex-column gap-20 filters_wrapper">
    <div class="filters d-flex gap-20">
        @foreach($filters as $filter)
            {!! $filter->render() !!}
        @endforeach
        @if($exportUrl)
            <div class="filter d-none d-lg-flex align-items-center">
                <a href="{{ $exportUrl }}">
                    <x-icon name="export"/>
                </a>
            </div>
        @endif
    </div>
    @if($hasFilter)
        <div class="d-none d-xl-flex justify-content-end">
            <button class="btn btn-light clear_filter">Сбросить фильтры</button>
        </div>
    @endif
</div>
