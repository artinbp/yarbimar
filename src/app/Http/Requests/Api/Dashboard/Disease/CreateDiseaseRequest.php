<?php

namespace App\Http\Requests\Api\Dashboard\Disease;

use App\Models\Disease;
use Illuminate\Foundation\Http\FormRequest;

class CreateDiseaseRequest extends FormRequest
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
            'name' => ['required', 'filled', 'string', 'unique:diseases,name']
        ];
    }
}
