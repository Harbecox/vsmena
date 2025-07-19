<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/';

//  public function __construct() {
//    $this->middleware('guest');
//  }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'fio' => 'required|max:255',
            'year_birth' => 'required|max:4',
            'phone' => 'required|max:11|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'captcha' => 'captcha',
        ], [
            'fio.required' => 'Введите имя пользователя',
            'fio.max' => 'Имя пользователя должно быть не длиннее 255 символов',
            'year_birth.max' => 'Год рождения должен быть не длиннее 4 символов',
            'phone.max' => 'Телефон должен быть не длиннее 11 символов',
            'phone.unique' => 'Пользователь с таким телефоном уже ' .
                'зарегистрирован',
            'email.required' => 'Введите адрес электронной почты',
            'email.email' => 'Введите корректный адрес электронной почты',
            'email.max' => 'Адрес электронной почты не должен превышать в длину 255 символов',
            'email.unique' => 'Пользователь с таким адресом электронной почты уже ' .
                'зарегистрирован',
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен включать не менее 6 символов',
            'password.confirmed' => 'В полях "Пароль" и "Подтверждение пароля" следует ' .
                'указать одно и то же значение',
            'captcha.captcha' => 'Введены не те символы',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'fio' => $data['fio'],
            'year_birth' => $data['year_birth'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
    }
}
