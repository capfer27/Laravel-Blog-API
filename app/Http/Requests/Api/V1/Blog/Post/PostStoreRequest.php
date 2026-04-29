<?php

namespace App\Http\Requests\Api\V1\Blog\Post;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'title' => [
            'required',     
            'string',       // Must be valid text
            'min:5',        // Minimum length for SEO/readability
            'max:255',      
            'unique:posts', // Prevents duplicate titles in the "posts" table
        ],
        'content' => [
            'required',
            'string',
            'min:20',       // Prevents "thin" content
            'max:65535',    // Matches standard TEXT column limit
        ],
    ];
    }
}
