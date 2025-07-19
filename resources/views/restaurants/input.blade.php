@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

<?php $h = ($cat->id) ? $cat->name : "Добавление" ?>
@section("title", $h . " :: Рестораны")
@section("main")
  <h1>@if ($cat->id) Редактирование {{ $cat->name }}
  @else Добавление @endif</h1>
  <form action="{{ action('RestaurantsController@save') }}" method="POST">
    @if ($cat->id)
      {{ method_field('PUT') }}
      <input type="hidden" name="id" value="{{ old('id', $cat->id) }}">
	@else
	  <input type="hidden" name="session_id" value="{{ auth()->user()->id }}">
    @endif
    {{ csrf_field() }}
    <label>Название</label>
    <input type="text" placeholder = "Ресторан 'Мелькомбинат'" size="70" name="name" class="source" value="{{ old('name', $cat->name) }}" required>
    @include("common.errors", ["el" => "name"])
    <label>Слаг</label>
    <input type="text" name="slug" size="70" class="destination" value="{{ old('slug', $cat->slug) }}"  required readonly>
    @include("common.errors", ["el" => "slug"])
    <label>Описание</label>
    <textarea name="description" class="comment-content">{{ old('description', $cat->description) }}</textarea>
    @include("common.errors", ["el" => "description"])
	
    <input type="submit" value="Сохранить">
  </form>
  <p><a href="/restaurants">Назад к списоку ресторанов</a></p>
@endsection
