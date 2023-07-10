<?php

namespace App\Http\Requests\Article;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'title' => 'required|string|min:3',
            'body' => 'required|string|max:1500',
            'published_at' => 'required|date',
            'tags' => 'array',
            'tags.*' => 'nullable|exists:tags,id'
        ];
    }

    // /**
    //  * Get validation messages
    //  *
    //  * @return array<string, mixed>
    //  */
    // public function messages()
    // {
    //     return [
    //         'title.required' => 'Заполните название статьи',
    //         'title.string' => 'Название должно быть строкой',
    //         'title.min' => 'Название должно быть не меньше :min символов',
    //         'body.required' => 'Заполните текст статьи',
    //         'body.string' => 'Текст должен быть строкой',
    //         'body.max' => 'Текст должен быть не больше :max символов',
    //         'published_at.required' => 'Заполните дату публикации',
    //         'published_at.date' => 'Дата публикации должна быть датой',
    //         'tags.exists' => 'Такого тэга не существует',
    //     ];
    // }
}
