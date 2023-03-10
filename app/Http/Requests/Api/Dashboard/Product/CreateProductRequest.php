<?php

namespace App\Http\Requests\Api\Dashboard\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'title' => ['required', 'filled', 'string'],
            'description' => ['required', 'filled', 'string'],
            'categories.*' => ['required', 'filled', 'numeric', 'distinct', 'exists:categories,id'],
            'price' => ['required', 'filled', 'numeric', 'gt:0'],
            'media' => ['array'],
            'media.*' => ['filled', 'numeric', 'distinct', 'exists:media,id'],
            'diseases' => ['array'],
            'diseases.*' => ['filled', 'numeric', 'distinct', 'exists:diseases,id'],
            'thumbnail_path' => ['required', 'filled', 'string', 'exists:media,path'],
            'stock' => ['required', 'filled', 'numeric'],
            'color' => ['required', 'filled', 'string'],
            'size' => ['required', 'filled', 'numeric'],
            'brand' => ['required', 'filled', 'string'],
            'manufacturing_country' => ['required', 'filled', 'string'],
            'weight' => ['required', 'filled', 'numeric'],
            'length' => ['required', 'filled', 'numeric'],
            'breadth' => ['required', 'filled', 'numeric'],
            'width' => ['required', 'filled', 'numeric'],
        ];
    }
}
