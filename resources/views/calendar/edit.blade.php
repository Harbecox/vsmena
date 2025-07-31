@extends("layouts.dashboard")

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <a href="{{ route('calendar.show',\Carbon\Carbon::parse($event->start_date)->toDateString()) }}" class="text-secondary d-flex gap-5 align-items-center">
                <x-icon name="back"/>
                <span class="text-secondary">Вернуться</span>
                <span class="text-success">Подтверждение смен</span>
            </a>
            <h1 class="text-primary">Редактирование смены</h1>
        </div>
    </div>
    <form action="{{ route('calendar.update',$event->id) }}" method="post" class="page_form_container w_xl">
        @csrf
        @method('PUT')
        <div class="d-flex gap-30 w-100">
            <div class="flex_1">
                <x-form.select
                    name="restorant_id"
                    :values="$restaurants"
                    label="Ресторана"
                    :required="true"
                    :selected="$event->restaurants_id"
                />
                <x-form.input-with-label
                    name="fio"
                    label="ФИО"
                    placeholder="ФИО"
                    :required="true"
                    :value="$event->fio"
                />
                <x-form.select
                    name="positions_id"
                    :values="$positions"
                    label="Должность"
                    :required="true"
                    :selected="$event->positions_id"
                />
                <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
            </div>
            <div class="flex_1">
                <x-form.input-with-label
                    label="Время начала смены"
                    icon="lock"
                    placeholder="Время начала смены"
                    name="start_date"
                    type="datetime"
                    :required="true"
                    :value="\App\Helpers\Helper::formatRussianDate($event->start_date)"
                />
                <x-form.input-with-label
                    label="Времяокончания смены"
                    icon="lock"
                    placeholder="Время начала смены"
                    name="end_date"
                    type="datetime"
                    :required="true"
                    :value="\App\Helpers\Helper::formatRussianDate($event->end_date)"
                />
            </div>
        </div>


    </form>
@endsection
