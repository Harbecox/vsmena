@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Редактирование смены"
        :back-url="route('calendar.show',\Carbon\Carbon::parse($event->start_date)->toDateString())"
        back-text="Подтверждение смен"
    />
@endsection

@section('content')
    <calendar-form method="PUT" :form-data="{
        'restaurant_id':{{ $event->position->restaurants_id }},
        'positions_id':{{ $event->position->id }},
        'start_date':'{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d H:i') }}',
        'end_date':'{{ \Carbon\Carbon::parse($event->end_date)->format('Y-m-d H:i') }}',
        'user_id':{{ $event->user_id }},
    }" action="{{ route('calendar.update',$event->id) }}" />
@endsection
