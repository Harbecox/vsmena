<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RestaurantsRequest extends FormRequest
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
            'name' => 'required|max:70',
            'slug' => 'required|max:70',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Введите название ресторана',
            'name.max' => 'Название ресторана должно быть не длиннее 70 символов',
            'slug.required' => 'Введите слаг',
            'slug.max' => 'Слаг должен быть не длиннее 70 символов',
        ];
    }
}
