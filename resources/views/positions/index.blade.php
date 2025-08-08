@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','Должность','Метод оплаты','Цена, руб','Описание','Действия'];
@endphp

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">Должности</h1>
            <h3 class="text-secondary">Каждая должность — новый опыт</h3>
        </div>
    </div>
    <x-form.table :columns="$columns" :items="$positions" fb-title="Добавить должность" fb-url="{{ route('positions.create') }}"/>
@endsection
