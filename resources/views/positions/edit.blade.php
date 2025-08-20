@extends("layouts.dashboard")

@section('page_header')
    <x-page-header
        title-primary="Добавить должность"
        :back-url="route('positions.index')"
        back-text="Должности"
    />
@endsection

@section('content')
    <form action="{{ $action }}" method="post" class="page_form_container w_xl">
        @csrf
        @method($method)
        <div class="d-flex flex-column flex-lg-row gap-lg-0 gap-15">
            <div class="d-flex gap-lg-30 w-100 flex-column flex-lg-row">
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
            <div class="d-flex gap-lg-30 w-100 flex-column flex-lg-row">
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
            <div class="d-flex gap-lg-30 w-100 flex-column flex-lg-row">
                <x-form.input-with-label
                    label="Описание должности"
                    placeholder="Введите описание..."
                    name="description"
                    :value="$position->description ?? old('description')"
                    class="flex_1"
                />
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-30">Сохранить</button>
    </form>
@endsection
