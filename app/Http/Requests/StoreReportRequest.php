<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'post_id' => 'required|exists:posts,post_id',
            'reason' => 'required|in:spam,harassment,misinformation,inappropriate,other',
            'details' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'post_id.required' => 'Post is required.',
            'post_id.exists' => 'The specified post does not exist.',
            'reason.required' => 'Please select a reason for the report.',
            'reason.in' => 'Invalid reason selected.',
            'details.max' => 'Details cannot exceed 500 characters.',
        ];
    }
}
