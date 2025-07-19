@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Пользователи")
@section("main")
  <h1>Список пользователей</h1>
  <div id="backgroundtable">
  <table class="list table-list">
    <tr>
      <th>ФИО</th>
	  <th>Год рождения</th>
	  <th>Телефон</th>
	   <th>E-mail</th>
      <th>Роль</th>
      <th colspan="2">&nbsp;</th>
    <tr>
    @foreach ($users as $user)
      <tr>
        <td>{{ $user->fio }}</td>
		<td>{{ $user->phone }}</td>
        <td class="center">{{ $user->friendly_role }}</td>
        <td class="links">
          <a href="{{ action('UserController@input',
          ['user' => $user->id]) }}">Редактировать</a>
        </td>
        <td class="links">
		 @if ($user->role != "m")
			  <a href="{{ action('UserController@destroy', ['user' => $user->id]) }}" class="adel">Удалить</a>
		  @else
			  <a href="{{ action('UserController@changepwd',
			  ['user' => $user->id]) }}">Сменить пароль</a>
        
		  @endif
        </td>
        <td>{{ $user->year_birth }}</td>
        <td>{{ $user->email }}</td>
      </tr>
    @endforeach
  </table>
  </div>
@endsection
