@extends("layouts.dashboard")
@php
    $columns = ['ФИО ','Год рождения','Телефон','Email','Роль','Действия'];
@endphp
@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">Профиль сотрудника</h1>
            <h3 class="text-secondary">Чтобы познакомиться поближе</h3>
        </div>
    </div>
    <x-form.table :columns="$columns" :items="$users"/>

    <form-example/>
@endsection

