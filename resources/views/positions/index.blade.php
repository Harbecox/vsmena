@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Должности")
@section("main")
  <h1>Список должностей</h1>
  <p><!--<a href="{{ route('positions.create') }}">Добавить</a>--></p>
  <div id="backgroundtable">
  <table class="list table-list">
    <tr>
      <th>Пользователь</th>
	  <th>Ресторан</th>
	  <th>Название должности</th>
      <th colspan="2">Действия</th>
      <th>Цена за смену</th>
	  <th>Цена за час</th>
	  <th>Описание</th>
      
    <tr>
    @foreach ($subcats as $subcat)
      <tr>
        <td class="truncate-text65">{{ $subcat->usrname }}</td>
		<td class="truncate-text45">{{ $subcat->restname }}</td>
		<td class="truncate-text45">{{ $subcat->name }}</td>
        <td class="links">
          <a href="{{ action('PositionsController@input',
          ['position' => $subcat->slug]) }}">Редактировать</a>
        </td>
        <td class="links">
          <a href="{{ action('PositionsController@destroy',
          ['position' => $subcat->slug]) }}" class="adel">Удалить</a>
        </td>
        <td class="center">{{ $subcat->price_shifts }}</td>
        <td class="center">{{ $subcat->price_hour }}</td>
		<td>{{ $subcat->description }}</td>
        
      </tr>
    @endforeach
  </table>
  </div>
@endsection
