@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','Должность','Метод оплаты','Цена, руб','Описание','Действия'];
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
    <x-form.table :columns="$columns" :items="$positions" fb-title="Добавить должность" fb-url="{{ route('positions.create') }}"/>
@endsection
