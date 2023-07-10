<?php

namespace App\Http\Requests\Monitoring;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'city' => 'required|string|min:3|max:255',
            'street' => 'required|string|min:3|max:255',
            'house_number' => 'required|string|min:1|max:255',
            'date' => 'required|date',
            'entrances' => 'required|array',
            'entrances.*' => 'nullable|integer|min:0|max:255',
            'floors' => 'required|array',
            'floors.*' => 'nullable|integer|min:-32|max:255',
            'stickers' => 'required|array',
            'stickers.*' => 'nullable|integer|min:0|max:512',
            'competitors' => 'nullable|array',
            'competitors.*' => 'nullable|integer|min:0|max:255',
            'countEntrances' => 'required|integer|min:5|max:255',
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'order_id' => 'nullable|integer|numeric'
        ];
    }
}
