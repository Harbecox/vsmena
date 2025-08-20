@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Добавить сотрудника"
        :back-url="route('staff.index')"
        back-text="Сейчас работают"
    />
@endsection

@section('content')
    <form action="{{ route('staff.store') }}" method="post" class="page_form_container">
        @csrf
        <x-form.select
            name="restorant_id"
            :values="$restaurants"
            label="Ресторана"
            :required="true"
        />
        <x-form.select
            name="positions_id"
            :values="$positions"
            label="Должность"
            :required="true"
        />
        <x-form.input-with-label
            name="fio"
            label="ФИО"
            placeholder="ФИО"
            :required="true"
        />
        <x-form.input-with-label
            label="Время начала смены"
            icon="lock"
            placeholder="Время начала смены"
            name="start_date"
            type="datetime"
            :required="true"
            :value="\App\Helpers\Helper::formatRussianDate(\Illuminate\Support\Carbon::now())"
        />
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
