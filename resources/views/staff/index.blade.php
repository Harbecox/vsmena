@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','Должность','ФИО','Время окончания смены','Действия '];
@endphp

@section('page_header')
    <x-page-header
        title-primary="Сейчас работают"
        title-secondary="Герои сегодняшнего дня"
    />
    <x-page-filters
        :filters="$filters"
    />
@endsection

@section('content')
    <x-form.table :columns="$columns" :items="$events" fbTitle="Добавить сотрудника" fbUrl="{{ route('staff.create') }}"/>
@endsection
