<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string|min:20',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'remove_image' => 'nullable|boolean',
            'tags' => 'nullable|array|max:5',
            'tags.*' => 'integer|exists:tags,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'category_id' => 'category',
            'featured_image' => 'featured image',
            'tags.*' => 'tag',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please choose a category for this post.',
            'body.min' => 'The post body is too short. Write at least :min characters.',
            'featured_image.max' => 'The image must be smaller than 2 MB.',
            'tags.max' => 'You can choose up to :max tags.',
        ];
    }
}