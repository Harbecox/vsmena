@extends("layouts.pc")

@section("title", "Сменить пароль")
@section("main")
  <h1>Сменить пароль</h1>
  <form method="POST" action="{{ action('UserController@update') }}">
    {{ csrf_field() }}
    {{ method_field('PUT') }}
    <input type="hidden" name="id" value="{{ old('id', $user->id) }}">
    <label>Пароль</label>
    <input type="password" size="70" name="password" required autofocus>
	@include("common.errors", ["el" => "password"])
    <input type="submit" value="Сменить пароль" >
  </form>
@endsection