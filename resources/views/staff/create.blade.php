@extends("layouts.dashboard")

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <a href="{{ route('staff.index') }}" class="text-secondary d-flex gap-5 align-items-center">
                <x-icon name="back"/>
                <span class="text-secondary">Вернуться</span>
                <span class="text-success">Сейчас работают</span>
            </a>
            <h1 class="text-primary">Редактировать данные</h1>
        </div>
    </div>
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
