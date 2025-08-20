@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Добавить ресторан"
        :back-url="route('restaurants.index')"
        back-text="Рестораны"
    />
@endsection

@section('content')
    <form action="{{ $action }}" method="post" class="page_form_container w_xl">
        @csrf
        @method($method)
        <div class="d-flex flex-column flex-lg-row">
            <div class="d-flex gap-lg-30 gap-0 w-100 flex-column flex-lg-row">
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
        </div>
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
