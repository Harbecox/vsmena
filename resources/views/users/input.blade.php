@extends("layouts.pc")

@section("title", $user->fio. " :: Пользователи")
@section("main")
  <h1>Пользователь {{ $user->fio }}</h1>
  <form method="POST" action="{{ action('UserController@save') }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" name="id" value="{{ old('id', $user->id) }}">
    <label>ФИО</label>
    <input type="text" size="70" name="fio" value="{{ old('fio', $user->fio) }}" required>
    @include("common.errors", ["el" => "fio"])
	<label>Год рождения</label>
    <input type="text" size="70" name="year_birth" placeholder="1980" value="{{ old('year_birth', $user->year_birth) }}" required>
    @include("common.errors", ["el" => "year_birth"])
	<label>Телефон</label>
    <input type="text" size="70" name="phone" placeholder="8XXXXXXXXXX" value="{{ old('phone', $user->phone) }}" required>
    @include("common.errors", ["el" => "phone"])
    <label>E-mail</label>
	@if ($user->role != "m") 
		<input type="email" size="70" name="email" value="{{ old('email', $user->email) }}" required >
	@else
		<input type="email" size="70" name="email" value="{{ old('email', $user->email) }}" required readonly>
	@endif
    @include("common.errors", ["el" => "email"])
    <label>Роль</label>
    <?php $r = old('role', $user->role); ?>
	<select name="role">
	@if ($user->role != "m")	
		<option value="a" @if ($r == "a") selected @endif>Сотрудник</option>
		<option value="e" @if ($r == "e") selected @endif>Менеджер</option>
		<option value="b" @if ($r == "b") selected @endif>Бухгалтер</option>
		<option value="m" @if ($r == "m") selected @endif>Администратор</option>
	@else
		<option value="a" @if ($r == "a") selected @endif disabled>Сотрудник</option>
		<option value="e" @if ($r == "e") selected @endif disabled>Менеджер</option>
		<option value="m" @if ($r == "b") selected @endif disabled>Бухгалтер</option>
		<option value="m" @if ($r == "m") selected @endif>Администратор</option>
	@endif
    </select>
    <input type="submit" value="Сохранить">
  </form>
  <p><a href="/users">Список пользователей</a></p>
@endsection
