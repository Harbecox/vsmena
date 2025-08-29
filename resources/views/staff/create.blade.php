@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Добавить сотрудника"
        :back-url="route('staff.index')"
        back-text="Сейчас работают"
    />
@endsection

@section('content')
    <div class="page_form_container">
        <staff-form action="{{ route('staff.store') }}"/>
    </div>
@endsection
