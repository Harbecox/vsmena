<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class passwordChangeRequest extends FormRequest
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
            'password' => 'required|min:6|confirmed',
        ];
    }

    public function messages() {
        return [
            'password.required' => 'Введите пароль',
            'password.min' => 'Пароль должен включать не менее 6 символов',
            'password.confirmed' => 'В полях "Пароль" и "Подтверждение пароля" следует ' .
                'указать одно и то же значение',
        ];
    }
}
