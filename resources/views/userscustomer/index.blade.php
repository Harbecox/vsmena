@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Профиль сотрудника"
        title-secondary="Чтобы познакомиться поближе"
    />
@endsection

@section('content')
    <x-form.table :columns="['ФИО ','Год рождения','Телефон','Email','Роль','Действия']" :items="$users"/>
@endsection

