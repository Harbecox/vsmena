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
            'price_shifts' => 'required',
            'price_hour' => 'required',
            'slug' => 'required|max:50',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название должности',
            'name.max' => 'Название должности должно быть не длиннее 50 символов',
            'slug.required' => 'Введите слаг',
            'slug.max' => 'Слаг должен быть не длиннее 50 символов',
            'price_shifts.required' => 'Введите цену за смену',
            'price_hour.required' => 'Введите цену за час',
        ];
    }
}
