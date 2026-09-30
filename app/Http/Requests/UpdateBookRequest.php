<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:150'],
            'year' => ['required', 'integer', 'between:1900,2100'],
            'isbn' => [
                'required',
                'string',
                Rule::unique('books', 'isbn')->ignore($this->route('book')),
            ],
        ];
    }
}