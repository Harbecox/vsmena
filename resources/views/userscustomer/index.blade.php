@extends("layouts.pc")

@push("head")
  <script src="/js/pc.js"></script>
@endpush

@section("title", "Пользователь")
@section("main")
  <h1>Профиль сотрудника</h1>
  <div id="backgroundtable">
  <table class="list">
    <tr>
      <th>ФИО</th>
	  <th>Год рождения</th>
	  <th>Телефон</th>
	   <th>E-mail</th>
      <th>Роль</th>
      <th colspan="2">&nbsp;</th>
	  </tr>
	 @foreach ($users as $user)
      <tr>
        <td>{{ $user->fio }}</td>
		<td>{{ $user->year_birth }}</td>
		<td>{{ $user->phone }}</td>
		<td>{{ $user->email }}</td>
        <td class="center">{{ $user->friendly_role }}</td>
        <td class="links">
			<a href="{{ action('UserCustomerController@input',
			['user' => $user->id]) }}">Редактировать</a>
        </td>
		<td class="links">
			<a href="{{ action('UserCustomerController@changepwd',
			  ['user' => $user->id]) }}">Сменить пароль</a>
		</td>
      </tr>
	  @endforeach
  </table>
  </div>
@endsection
