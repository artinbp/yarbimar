<?php

namespace App\Http\Requests\Api\Dashboard\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'title' => ['filled'],
            'parent_id' => ['filled', 'numeric', 'exists:categories,id'],
            'description' => ['filled', 'string'],
            'disabled' => ['filled', 'boolean']
        ];
    }
}
