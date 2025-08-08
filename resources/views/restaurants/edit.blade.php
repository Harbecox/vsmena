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
    <form action="{{ $action }}" method="post" class="page_form_container w_xl">
        @csrf
        @method($method)
        <div class="d-flex gap-30 w-100">
            <x-form.input-with-label
                name="name"
                :value="($restaurant->name ?? '')"
                label="Название ресторана"
                placeholder="Введите название..."
                :required="true"
                class="flex_1"
            />
            <v-choice
                :model-value='@json($restaurant->user?->id)'
                :items='@json($managers)'
                :required="true"
                name="user_id"
                label="Назначить менеджера"
                placeholder="Поиск..."
            />
        </div>
        <x-form.input-with-label
            name="description"
            :value="$restaurant->description"
            label="Описание ресторана"
            placeholder="Введите описание..."
            :required="false"
            class="flex_1"
        />
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
