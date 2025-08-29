<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'fio' => 'required',
            'year_birth' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'politics' => 'required',
        ];
    }

    public function messages() {
        return [
            'fio.required' => 'ФИО не заполнено',
            'year_birth.required' => 'Год рождения не указан',
            'phone.required' => 'Телефон не заполнен',
            'email.required' => 'Email не заполнен',
            'email.email' => 'Некорректный email',
            'email.unique' => 'Такой email уже зарегистрирован',
            'password.required' => 'Пароль не заполнен',
            'password.confirmed' => 'Пароли не совпадают',
            'politics.required' => 'Нужно принять политику конфиденциальности',
        ];
    }
}
