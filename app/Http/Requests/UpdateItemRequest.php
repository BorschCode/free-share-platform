<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'weight' => 'nullable|numeric',
            'dimensions' => 'nullable|string|max:255',
            'photos.*' => 'nullable|image|max:2048',
            'status' => 'nullable|integer|in:10,20,30,31,40,41',
        ];
    }
}
