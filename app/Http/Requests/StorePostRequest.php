<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'post_content' => 'required|string|min:1|max:5000',
            'category' => 'required|in:academic,events,announcement,campus_life,help_wanted',
            'link' => 'nullable|url|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'status' => 'nullable|in:active,hidden',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'post_content.required' => 'Post content is required.',
            'post_content.min' => 'Post content must contain at least 1 character.',
            'post_content.max' => 'Post content cannot exceed 5000 characters.',
            'category.required' => 'Please select a category.',
            'category.in' => 'Invalid category selected.',
            'link.url' => 'Please enter a valid URL.',
            'image.image' => 'File must be an image.',
            'image.mimes' => 'Image must be a JPEG, PNG, JPG, or GIF file.',
            'image.max' => 'Image cannot exceed 5MB.',
        ];
    }
}
