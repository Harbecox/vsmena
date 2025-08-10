@extends("layouts.dashboard")

@php
    $columns = ['Дата','Объект','Событие','Ответственный'];
@endphp

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">Список событий</h1>
            <h3 class="text-secondary">Все важные моменты — в одном месте</h3>
        </div>

    </div>
    <x-form.table :columns="$columns" :items="$logs" />
@endsection
