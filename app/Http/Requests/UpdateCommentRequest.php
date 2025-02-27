<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
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
            'comment' => 'required|min:5|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'comment.required' => 'Комментарий обязателен для заполнения.',
            'comment.min' => 'Комментарий должен содержать не менее 5 символов.',
            'comment.max' => 'Комментарий не должен превышать 1000 символов.',
        ];
    }
}
