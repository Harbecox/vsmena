@extends("layouts.dashboard")

@php
    $columns = ['ФИО ','Год рождения','Телефон','Email','Роль','Действия'];
@endphp

@section('page_header')
    <x-page-header
        title-primary="Пользователи"
        title-secondary="Каждая должность — новый опыт"
    />
@endsection

@section('content')
    <x-form.table :columns="$columns" :items="$users" />
@endsection
