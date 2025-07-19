@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

<?php $h = ($subcat->id) ? $subcat->name : "Добавление" ?>
@section("title", $h . " :: Должности")
@section("main")
  <h1>@if ($subcat->id) Редактирование {{ $subcat->name }}
  @else Добавление @endif</h1>
  <form action="{{ action('PositionsManagerController@save') }}" method="POST">
    @if ($subcat->id)
      {{ method_field('PUT') }}
      <input type="hidden" name="id" value="{{ old('id', $subcat->id) }}">
	@else 
	  <input type="hidden" name="users_id" value="2">
	  <!----------------------$rest_id---------------------------------->
	  <input type="hidden" name="rest_id" value="{{ $rest_id }}">
    @endif
    {{ csrf_field() }}
    <label>Наименование должности</label>
    <input type="text" placeholder = "официант" size="70" name="name" class="source" value="{{ old('name', $subcat->name) }}" required>
    @include("common.errors", ["el" => "name"])
	<label>Цена за смену руб.</label>
    <input type="number" min="0" max="1000000" step="0.01" placeholder = "3000" name="price_shifts" id="input_one" class="source" value="{{ old('price_shifts', $subcat->price_shifts) }}" required>
	<!------------------------------------------------------->
	<input type="radio" name="pr" id="radio_one" />Метод оплаты за смену
	<!------------------------------------------------------->
    @include("common.errors", ["el" => "price_shifts"])
	<label>Цена за час руб.</label>
    <input type="number" min="0" max="1000000" step="0.01" placeholder = "250" name="price_hour" id="input_two" class="source" value="{{ old('price_hour', $subcat->price_hour) }}" required>
	<!------------------------------------------------------->
	<input type="radio" name="pr" id="radio_two" checked />Метод оплаты за час
	<!------------------------------------------------------->
    @include("common.errors", ["el" => "price_hour"])
	<label>Цена за месяц руб.</label>
    <input type="number" min="0" max="1000000" step="0.01" placeholder = "100000" name="price_month" id="input_three" class="source" value="{{ old('price_month', $subcat->price_month) }}" required>
	<!------------------------------------------------------->
	<input type="radio" name="pr" id="radio_three" />Метод оплаты за месяц
	<!------------------------------------------------------->
    @include("common.errors", ["el" => "price_month"])
    <label>Слаг</label>
    <input type="text" name="slug" size="70" class="destination" value="{{ old('slug', $subcat->slug) }}"
    required readonly>
    @include("common.errors", ["el" => "slug"])
	<!----------------------erase---------------------------------->
   <!-- <label>ФИО сотрудника</label>
    <select name="users_id">
      @foreach ($cats as $cat)
        <option value="{{ $cat->id }}" @if (old('users_id', $subcat->users_id) == $cat->id)
        selected @endif>{{ $cat->fio }}</option>
      @endforeach
    </select>
    @include("common.errors", ["el" => "users_id"])-->
	<!------------------------------------------------------------->
	<label>Название ресторана</label>
    <select name="restaurants_id">
	
      @foreach ($rests as $rest)
        <option value="{{ $rest->id }}" 
		@if ($subcat->id)
			@if (old('restaurants_id', $subcat->restaurants_id) == $rest->id)
			selected @endif>{{ $rest->name }}</option>
		@else
			@if (old('restaurants_id', $rest->id) == $rest_id)
			selected @endif>{{ $rest->name }}</option>
		@endif
      @endforeach
    </select>
    @include("common.errors", ["el" => "restaurants_id"])
    <label>Описание</label>
	<textarea name="description" size="70" class="comment-content">{{ old('description', $subcat->description) }}</textarea>
    @include("common.errors", ["el" => "description"])
	
    <input type="submit" value="Сохранить">
  </form>
  <p><a href="/restaurants">Назад к ресторанам</a></p>
@endsection
