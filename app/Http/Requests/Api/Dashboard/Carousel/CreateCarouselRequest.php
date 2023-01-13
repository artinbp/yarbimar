<?php

namespace App\Http\Requests\Api\Dashboard\Carousel;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarouselRequest extends FormRequest
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
            'title' => ['required', 'filled'],
            'media_id' => ['required', 'filled', 'numeric', 'exists:media,id'],
            'description' => ['required', 'filled', 'string'],
            'url' => ['required', 'filled', 'url'],
        ];
    }
}
