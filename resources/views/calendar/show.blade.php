@extends("layouts.dashboard")

@php
    $columns = ['Ресторан ','Должность','ФИО','Время начала','Время окончания','Действия '];
@endphp

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <a href="{{ route('calendar.index') }}" class="text-secondary d-flex gap-5 align-items-center">
                <x-icon name="back"/>
                <span class="text-secondary">Вернуться</span>
                <span class="text-success">Подтверждение смен</span>
            </a>
            <h1 class="text-primary">{{ $date }}</h1>
        </div>
        <div class="d-flex flex-column gap-20">
            <div class="filters d-flex gap-20">
                @foreach($filters as $filter)
                    {!! $filter->render() !!}
                @endforeach
            </div>
            @if(request()->has('restorant'))
                <div class="d-flex justify-content-end">
                    <button class="btn btn-light clear_filter">Сбросить фильтры</button>
                </div>
            @endif
        </div>
    </div>
    <x-form.table :columns="$columns" :items="$events" fbTitle="Добавить сотрудника" fbUrl="{{ route('calendar.create') }}"/>
@endsection
