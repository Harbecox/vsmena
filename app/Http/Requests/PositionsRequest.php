<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PositionsRequest extends FormRequest
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
            'name' => 'required|max:50',
            'payment_amount' => 'required',
            'payment_method' => 'required',
            'description' => 'nullable|max:200',
            'restaurants_id' => 'required|exists:restaurants,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название должности',
            'name.max' => 'Название должности должно быть не длиннее 50 символов',
            'slug.max' => 'Описание должен быть не длиннее 50 символов',
            'payment_method.required' => 'Выберите метод оплаты',
            'payment_amount.required' => 'Введите цену',
        ];
    }
}
