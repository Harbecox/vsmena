@extends("layouts.pc")

@section("title", $user->fio. " :: Пользователь")
@section("main")
  <h1>Пользователь {{ $user->fio }}</h1>
  <form method="POST" action="/usersmanager">
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
		<input type="email" size="70" name="email" value="{{ old('email', $user->email) }}" required >
    @include("common.errors", ["el" => "email"])  
    <input type="submit" value="Сохранить">
  </form>
  <p><a href="/usersmanager">Сотрудники ресторана</a></p>
@endsection
