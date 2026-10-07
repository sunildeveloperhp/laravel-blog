<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    // Is this user allowed to make this request?
    // Everyone for now. Week 3 adds "only the owner can edit".
    public function authorize(): bool
    {
        return true;
    }

    // The validation rules (used for both create and update)
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string|min:20',
        ];
    }

    // Nicer field names inside error messages
    // ("The category field is required." instead of "The category id field is required.")
    public function attributes(): array
    {
        return [
            'category_id' => 'category',
        ];
    }

    // Fully custom messages for specific rules
    public function messages(): array
    {
        return [
            'category_id.required' => 'Please choose a category for this post.',
            'body.min' => 'The post body is too short. Write at least :min characters.',
        ];
    }
}