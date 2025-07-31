@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','Должность','ФИО','Время окончания смены','Действия '];
@endphp

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <h1 class="text-primary">Сейчас работают</h1>
            <h3 class="text-secondary">Герои сегодняшнего дня</h3>
        </div>
        <div class="d-flex flex-column gap-20">
            <div class="filters d-flex gap-20">
                @foreach($filters as $filter)
                    {!! $filter->render() !!}
                @endforeach
            </div>
            @if(request()->has('restorant'))
                <div class="d-flex justify-content-end">
                    <button class="btn btn-light clear_filter" >Сбросить фильтры</button>
                </div>
            @endif
        </div>

    </div>
    <x-form.table :columns="$columns" :items="$events" fbTitle="Добавить сотрудника" fbUrl="{{ route('staff.create') }}"/>
@endsection
