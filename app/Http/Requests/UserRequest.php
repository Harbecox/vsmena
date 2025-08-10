<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'fio' => 'required|max:255',
            'email' => 'required|email|max:255',
            'year_birth' => 'required|max:4',
            'phone' => 'required|max:11',
            'role' => 'nullable',
        ];
    }

    public function messages() {
        return [
            'fio.required' => 'Введите имя пользователя',
            'fio.max' => 'Имя пользователя должно быть не длиннее 255 символов',
            'year_birth.max' => 'Год рождения должен быть не длиннее 4 символов',
            'phone.max' => 'Телефон должен быть не длиннее 11 символов',
            'email.required' => 'Введите адрес электронной почты',
            'email.email' => 'Введите корректный адрес электронной почты',
            'email.max' => 'Адрес электронной почты не должен превышать в длину 255 символов',
        ];
    }
}
