@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','Описание','Ответственный менеджер','Действия'];
@endphp

@section('page_header')
    <x-page-header
        title-primary="Список ресторанов"
        title-secondary="Мои точки на гастрономической карте"
    />
@endsection

@section('content')
    <x-form.table :columns="$columns" :items="$restaurants" fb-title="Добавить ресторан" fb-url="{{ route('restaurants.create') }}"/>
@endsection
