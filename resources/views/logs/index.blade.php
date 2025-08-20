@extends("layouts.dashboard")

@php
    $columns = ['Дата','Объект','Событие','Ответственный'];
@endphp

@section('page_header')
    <x-page-header
        title-primary="Список событий"
        title-secondary="Все важные моменты — в одном месте"
    />
@endsection

@section('content')
    <x-form.table :columns="$columns" :items="$logs" />
@endsection
