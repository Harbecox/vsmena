@extends("layouts.pc")

@section("title", "Сброс пароля")
@section("main")
  <h1>Сброс пароля</h1>
  <form method="POST" action="/password/reset">
    {{ csrf_field() }}
    <input type="hidden" name="token" value="{{ $token }}">
    <label>E-mail</label>
	@php
		if (isset($_GET['email'])) {
			$email = $_GET['email'];
		}
	@endphp
    <input type="email" name="email" value="{{ $email }}" required autofocus readonly>
    @include("common.errors", ["el" => "email"])
    <label>Пароль</label>
    <input type="password" name="password" required>
    @include("common.errors", ["el" => "password"])
    <label>Подтверждение пароля</label>
    <input type="password" name="password_confirmation" required>
    <input type="submit" value="Сбросить пароль">
  </form>
@endsection
