@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','Должность','ФИО','Время начала','Время окончания','Действия '];
@endphp

@section('page_header')
    <x-page-header
        title-primary="История моих смен"
        back-text="Подтверждение смен"
        :back-url="route('calendar.index')"
    />
    <x-page-filters
        :filters="$filters"
    />
@endsection

@section('content')
    <x-form.table :columns="$columns" :items="$events" fbTitle="Добавить сотрудника" fbUrl="{{ route('calendar.create') }}"/>
@endsection
