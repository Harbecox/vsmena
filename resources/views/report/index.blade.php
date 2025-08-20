@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','ФИО','Должность','Часов','Ставка, руб','Сумма, руб','Пометки','Итого, руб'];
@endphp

@section('page_header')
    <x-page-header
        title-primary="Должности"
        title-secondary="Каждая должность — новый опыт"
    />

    <x-page-filters
        :filters="$filters"
    />
@endsection

@section('content')
    <x-form.table :columns="$columns" :items="$reports" />
@endsection
