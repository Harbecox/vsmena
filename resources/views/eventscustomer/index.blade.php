@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="История моих смен"
        title-secondary="Место, где каждый день — новый вкус"
        :export-url="$export_url"
    />
    <x-page-filters
        :filters="$filters"
        :export-url="$export_url"
    />
@endsection

@section('content')
    <x-form.table :columns="['Ресторан ','Должность','Время начала','Время окончания','Длительность смены','Статус смены']" :items="$events"/>
@endsection
