@extends("layouts.dashboard")

@php
    $columns = ['Кому выдано','Дата создания','Дата выдачи','Премия или штраф','Комментарий','Ответственный'];
@endphp

@section('page_header')
    <x-page-header
        title-primary="История премий и штрафов"
        title-secondary="Мотивация в каждом бонусе"
        :export-url="$export_url"
    />
    <x-page-filters
        :filters="$filters"
        :export-url="$export_url"
    />
@endsection

@section('content')
    <x-form.table :columns="$columns" :items="$reward"/>
@endsection
