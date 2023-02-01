<?php

namespace App\Http\Requests\Api\Dashboard\Disease;

use App\Models\Disease;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDiseaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $disease = Disease::findOrFail($this->route('id'));

        return [
            'name' => ['required', 'filled', 'string', 'unique:diseases,name,'.$disease->id]
        ];
    }
}
