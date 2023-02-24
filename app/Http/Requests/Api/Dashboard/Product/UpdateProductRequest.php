<?php

namespace App\Http\Requests\Api\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'title' => ['filled', 'string'],
            'description' => ['filled', 'string'],
            'categories' => ['array'],
            'categories.*' => ['filled', 'numeric', 'distinct', 'exists:categories,id'],
            'price' => ['filled', 'numeric'],
            'media' => ['array'],
            'media.*' => ['filled', 'numeric', 'distinct', 'exists:media,id'],
            'diseases' => ['array'],
            'diseases.*' => ['filled', 'numeric', 'distinct', 'exists:diseases,id'],
            'thumbnail_path' => ['filled', 'string', 'exists:media,path'],
            'stock' => ['filled', 'numeric'],
            'colors' => ['filled', 'array'],
            'colors.*' => ['filled', 'string'],
            'sizes' => ['filled', 'array'],
            'sizes.*' => ['filled', 'string'],
            'brand' => ['filled', 'string'],
            'manufacturing_country' => ['filled', 'string'],
            'weight' => ['filled', 'numeric'],
            'length' => ['filled', 'numeric'],
            'breadth' => ['filled', 'numeric'],
            'width' => ['filled', 'numeric'],
        ];
    }
}
