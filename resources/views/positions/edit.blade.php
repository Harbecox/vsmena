@extends("layouts.dashboard")

@section('content')
    <div class="page_header d-flex justify-content-between mb-30">
        <div class="d-flex flex-column gap-5">
            <a href="{{ route('staff.index') }}" class="text-secondary d-flex gap-5 align-items-center">
                <x-icon name="back"/>
                <span class="text-secondary">Вернуться</span>
                <span class="text-success">Должности</span>
            </a>
            <h1 class="text-primary">Добавить должность</h1>
        </div>
    </div>
    <form action="{{ $action }}" method="post" class="page_form_container w_xl">
        @csrf
        @method($method)
        <div class="d-flex gap-30 w-100">
            <div class="flex_1">
                <v-select
                    :model-value='@json($position->restaurants_id)'
                    name="restaurants_id"
                    label="Название ресторана"
                    :items='@json($restaurants)'
                    :errors="@if($errors->has('restaurants_id'))@json($errors->get('restaurants_id'))@endif"
                />
            </div>
            <x-form.input-with-label
                name="name"
                :value="($position->name ?? old('name'))"
                label="Название должности"
                placeholder="Введите название..."
                :required="true"
                class="flex_1"
            />

        </div>

        <div class="d-flex gap-30 w-100">
            <div class="flex_1">
                <div class="flex_1">
                    <v-select
                        :model-value='@json($position->payment_method)'
                        name="payment_method"
                        label="Метод оплаты"
                        :items='@json(\App\Enum\PaymentMethod::forSelect())'
                    />
                </div>
            </div>
            <x-form.input-with-label
                name="payment_amount"
                :value="$position->payment_amount ?? old('payment_amount')"
                label="Цена, руб"
                placeholder="Введите цену..."
                :required="true"
                class="flex_1"
            />

        </div>
        <div class="d-flex gap-30 w-100">
            <x-form.input-with-label
                label="Описание должности"
                placeholder="Введите описание..."
                name="description"
                :value="$position->description ?? old('description')"
                class="flex_1"
            />
        </div>
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
