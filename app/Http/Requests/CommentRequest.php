<?php

namespace App\Http\Requests;

use App\Models\Comment;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Comment::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:500',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'content.required' => 'The comment content is required.',
            'content.string' => 'The comment must be a valid text.',
            'content.max' => 'The comment cannot exceed 500 characters.',
        ];
    }
}
