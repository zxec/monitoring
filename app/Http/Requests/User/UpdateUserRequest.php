<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|string|confirmed|min:8|max:255',
            'department_id' => 'nullable|integer|exists:departments,id',
            'position_id' => 'nullable|integer|exists:positions,id',
            'gender_id' => 'nullable|integer|exists:genders,id',
            'status_id' => 'nullable|integer|exists:statuses,id',
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }
}
