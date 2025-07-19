@extends("layouts.pc")

@section("title", "Экспорт в Эксель")
@section("main")
  <h1>Экспорт в Эксель</h1>
  <form method="POST" action="{{ action('EventController@downloads') }}">
    {{ csrf_field() }}
    {{ method_field('POST') }}
    <label>Название ресторана</label>
    <select name="restaurants_id">
	<option value="0" >--- Все ---</option>
      @foreach ($rests as $rest)
        <option value="{{ $rest->id }}" >{{ $rest->name }}</option>
      @endforeach
    </select>
    @include("common.errors", ["el" => "restaurants_id"])
	<label>ФИО сотрудника</label>
    <select name="users_id">
	<option value="0" >--- Все ---</option>
      @foreach ($users as $cat)
        <option value="{{ $cat->id }}" >{{ $cat->fio }}</option>
      @endforeach
    </select>
    @include("common.errors", ["el" => "users_id"])
    <label>Дата начала отчета</label>
	<input type="date" name="start_date" required />
	<label>Дата окончания отчета</label>
	<input type="date" name="end_date" required />
    <input type="submit" value="Загрузить">
  </form>
  <p><a href="/events/eventpage">Календарь смен</a></p>
@endsection