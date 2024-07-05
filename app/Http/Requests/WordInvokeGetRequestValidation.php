<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class WordInvokeGetRequestValidation extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'word' => 'required|string|exists:words,word_original',
        ];
    }
    public function messages(): array
    {
        return [
            'word.required' => 'The word is required.',
            'word.string' => 'The word must be a string.',
            'word.exists' => 'Word not exist in database.',
        ];
    }
}
