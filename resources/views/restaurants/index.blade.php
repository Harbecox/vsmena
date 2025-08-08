@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','Описание','Ответственный менеджер','Действия'];
@endphp

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">Список ресторанов</h1>
            <h3 class="text-secondary">Мои точки на гастрономической карте</h3>
        </div>
    </div>
    <x-form.table :columns="$columns" :items="$restaurants"/>
@endsection
