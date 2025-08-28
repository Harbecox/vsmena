@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Добавить смену"
        back-text="Подтверждение смен"
        :back-url="route('calendar.index')"
    />
@endsection

@section('content')
<calendar-form action="{{ route('calendar.store') }}" />

@endsection
