@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Редактировать данные"
        :back-url="route('staff.index')"
        back-text="Сейчас работают"
    />
@endsection

@section('content')
    <div class="page_form_container">
        <staff-form method="PUT" action="{{ route('staff.update',$event->id) }}"
            :form-data="{
                'restaurant_id':{{ $event->position->restaurants_id }},
                'positions_id':{{ $event->position->id }},
                'start_date':'{{ \Carbon\Carbon::parse($event->start_date)->format('Y-m-d H:i') }}',
                'user_id':{{ $event->user_id }},
            }"
        />
    </div>
@endsection
