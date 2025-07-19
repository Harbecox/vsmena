@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Рестораны")
@section("main")
  <h1>Список ресторанов</h1>
  <p><a href="{{ route('restaurants.create') }}">Добавить</a></p>
  <div id="backgroundtable">
  <table class="list table-list">
    <tr>
      <th>Название ресторана</th>
	  <th style="display: none">Описание</th>
      <th colspan="3">Действия</th>
    </tr>
    @foreach ($cats as $cat)
      <tr>
        <td class="truncate-text65">{{ $cat->name }}</td>
		<td style="display: none" class="truncate-text45">{{ $cat->description }}</td>
		
		
		<td style="display: none"></td>
		<!--<td>{{ $cat->slug }}</td>-->
		<td class="links">
          <a href="{{ action('RestaurantsController@input',
          ['restaurant' => $cat->slug]) }}">Редактировать</a>
        </td>
        <td class="links">
			<a href="/positionsmanager?rest_id={{ $cat->id }}">Должности</a>
		</td>
        <td class="links">
          <a href="{{ action('RestaurantsController@destroy',
          ['restaurant' => $cat->slug]) }}" class="adel">Удалить</a>
        </td>
		
      </tr>
    @endforeach
  </table>
  </div>
@endsection
