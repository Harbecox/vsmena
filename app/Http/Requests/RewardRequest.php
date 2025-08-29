<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RewardRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'date' => 'required',
            'amount' => 'required',
            'type' => 'required',
            'comment' => 'nullable'
        ];
    }

    public function messages() {
        return [
            'user_id.required' => 'Пользователь не выбран',
            'date.required' => 'Дата не указана',
            'amount.required' => 'Сумма не заполнена',
            'type.required' => 'Тип не выбран',
        ];
    }
}
