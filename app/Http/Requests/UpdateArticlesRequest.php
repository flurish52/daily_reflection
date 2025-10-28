<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticlesRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'author' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'status' => 'sometimes|required|in:draft,published,archived',
            'reading_time' => 'nullable|integer|min:1',
            'category_id' => 'sometimes|required|exists:categories,id',
            'archive_id' => 'nullable|exists:archives,id',
            'tags' => 'nullable|json',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $this->article->id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'focus_keyword' => 'nullable|string|max:255',
            'visibility' => 'nullable|in:public,private',
            'allow_comments' => 'boolean',
            'is_featured' => 'boolean',
            // can be either an uploaded file or an existing string URL
            'featured_image' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (!is_string($value) && !$value instanceof \Illuminate\Http\UploadedFile) {
                        $fail('The featured image must be a valid URL or uploaded file.');
                    }
                },
            ],
            'published_at' => 'nullable|date',
        ];
    }

}
