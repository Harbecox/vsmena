@extends("layouts.dashboard")

@php
    $columns = ['Кому выдано','Дата создания','Дата выдачи','Премия или штраф','Комментарий','Ответственный'];
@endphp

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">История премий и штрафов</h1>
            <h3 class="text-secondary">Мотивация в каждом бонусе</h3>
        </div>
        <div class="d-flex flex-column gap-20">
            <div class="filters d-flex gap-20">
                @foreach($filters as $filter)
                    {!! $filter->render() !!}
                @endforeach
                @if(!empty($export_url))
                    <div class="filter d-flex align-items-center">
                        <a href="{{ $export_url }}">
                            <x-icon name="export"/>
                        </a>
                    </div>
                @endif
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-light clear_filter">Сбросить фильтры</button>
            </div>
        </div>
    </div>
    <x-form.table :columns="$columns" :items="$reward"/>
@endsection
