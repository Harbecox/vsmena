@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','ФИО','Должность','Часов','Ставка, руб','Сумма, руб','Пометки','Итого, руб'];
@endphp

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">Должности</h1>
            <h3 class="text-secondary">Каждая должность — новый опыт</h3>
        </div>
        <div class="d-flex flex-column gap-20">
            <div class="filters d-flex gap-20">
                @foreach($filters as $filter)
                    {!! $filter->render() !!}
                @endforeach
            </div>
            <div class="d-flex justify-content-end">
                <button class="btn btn-light clear_filter" >Сбросить фильтры</button>
            </div>
        </div>
    </div>
    <x-form.table :columns="$columns" :items="$reports" />
@endsection
