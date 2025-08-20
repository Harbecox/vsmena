@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Добавить сотрудника"
        back-text="Подтверждение смен"
        :back-url="route('calendar.index')"
    />
@endsection

@section('content')
    <form action="{{ route('calendar.store') }}" method="post" class="page_form_container w_xl">
        @csrf
        <div class="d-flex gap-30 w-100 flex-xl-row flex-column">
            <div class="flex_1">
                <x-form.select
                    name="restorant_id"
                    :values="$restaurants"
                    label="Ресторана"
                    :required="true"
                />
                <x-form.input-with-label
                    name="fio"
                    label="ФИО"
                    placeholder="ФИО"
                    :required="true"
                />
                <x-form.select
                    name="positions_id"
                    :values="$positions"
                    label="Должность"
                    :required="true"
                />
            </div>
            <div class="flex_1">
                <x-form.input-with-label
                    label="Время начала смены"
                    icon="lock"
                    placeholder="Время начала смены"
                    name="start_date"
                    type="datetime"
                    :required="true"
                />
                <x-form.input-with-label
                    label="Времяокончания смены"
                    icon="lock"
                    placeholder="Время начала смены"
                    name="end_date"
                    type="datetime"
                    :required="true"
                />
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
