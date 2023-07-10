<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name' => "required|string|unique:roles|min:3|max:255",
            'articles_permissions' => 'array',
            'users_permissions' => 'array',
            'department_permissions' => 'array',
            'positions_permissions' => 'array',
            'roles_permissions' => 'array',
            'articles_permissions.*' => 'nullable|integer|exists:permissions,id',
            'users_permissions.*' => 'nullable|integer|exists:permissions,id',
            'departments_permissions.*' => 'nullable|integer|exists:permissions,id',
            'positions_permissions.*' => 'nullable|integer|exists:permissions,id',
            'roles_permissions.*' => 'nullable|integer|exists:permissions,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Название обязательно для заполнения.',
            'string' => 'Название должно быть строкой.',
            'name.unique' => 'Такая роль уже существует',
            'name.min'  => "Название должно быть не короче :min символов.",
            'name.max'  => "Название должно быть не длиннее :max символов.",
        ];
    }
}
