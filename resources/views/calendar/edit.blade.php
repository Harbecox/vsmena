@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Редактирование смены"
        :back-url="route('calendar.show',\Carbon\Carbon::parse($event->start_date)->toDateString())"
        back-text="Подтверждение смен"
    />
@endsection

@section('content')

    <form action="{{ route('calendar.update',$event->id) }}" method="post" class="page_form_container w_xl">
        @csrf
        @method('PUT')
        <div class="d-flex gap-30 w-100 flex-xl-row flex-column">
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
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
