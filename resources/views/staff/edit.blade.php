@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Редактировать данные"
        :back-url="route('staff.index')"
        back-text="Сейчас работают"
    />
@endsection

@section('content')
    <form action="{{ route('staff.update',$event->id) }}" method="post" class="page_form_container">
        @csrf
        @method('PUT')
        <x-form.select
            name="restorant_id"
            :values="$restaurants"
            label="Ресторана"
            :selected="$event->restaurants_id"
        />
        <x-form.select
            name="positions_id"
            :values="$positions"
            label="Должность"
            :selected="$event->positions_id"
        />
        <x-form.input-with-label
            name="fio"
            :value="$event->fio"
            label="ФИО"
            placeholder="ФИО"
            :looked="true"
        />
        <x-form.input-with-label
            label="Время начала смены"
            icon="lock"
            placeholder="Время начала смены"
            name="start_date"
            type="datetime"
            :value="\App\Helpers\Helper::formatRussianDate($event->start_date)"
        />
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
