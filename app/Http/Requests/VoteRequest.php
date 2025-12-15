<?php

namespace App\Http\Requests;

use App\Models\Vote;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class VoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $item = $this->route('item');

        return Gate::allows('create', [Vote::class, $item]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'vote' => 'required|integer|in:-1,1',
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
            'vote.required' => 'A vote value is required.',
            'vote.integer' => 'Vote must be an integer.',
            'vote.in' => 'Vote must be either -1 (downvote) or 1 (upvote).',
        ];
    }
}
