<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|unique:departments|min:3|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название обязательно для заполнения.',
            'string' => 'Название должно быть строкой.',
            'name.unique' => 'Такой отдел уже существует',
            'name.min'  => 'Название должно быть не короче :min символов.',
            'name.max'  => 'Название должно быть не длиннее :max символов.',
        ];
    }
}
