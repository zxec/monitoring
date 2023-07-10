<?php

namespace App\Http\Requests\Calendar;

use Illuminate\Foundation\Http\FormRequest;

class CalendarRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:255',
            'start' => 'required|date',
            'end' => 'required|date',
            'user_id' => 'required|integer|exists:users,id',
            'creator' => 'required|integer|exists:users,id',
            'completed' => 'nullable|int|min:0|max:1',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Название обязательно для заполнения.',
            'title.string' => 'Название должно быть строкой.',
            'title.min'  => 'Название должно быть не короче :min символов.',
            'title.max'  => 'Название должно быть не длиннее :max символов.',
        ];
    }
}
