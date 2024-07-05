<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class WordInvokeStoreRequestValidation extends FormRequest
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
            'word_original' => 'required|string|unique:words,word_original',
            'target_language' => 'required|string|max:5',
        ];
    }
    public function messages(): array
    {
        return [
            'word_original.required' => 'The word_original field is required.',
            'word_original.string' => 'The word_original field must be a string.',
            'word_original.unique' => 'The word_original field must be unique in database.',
            'target_language.required' => 'The target_language field is required.',
            'target_language.string' => 'The target_language field must be a string.',
            'target_language.max' => 'The target_language field may not be greater than 5 characters.',
        ];
    }

}
