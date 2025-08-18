@extends("layouts.dashboard")

@section('page_header')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">Профиль сотрудника</h1>
            <h3 class="text-secondary">Чтобы познакомиться поближе</h3>
        </div>
    </div>
@endsection

@section('content')
    <x-form.table :columns="['ФИО ','Год рождения','Телефон','Email','Роль','Действия']" :items="$users"/>
@endsection

