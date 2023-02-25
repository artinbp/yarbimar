<?php

namespace App\Http\Requests\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $user = auth()->user();

        return [
            'username' => ['filled', 'string', 'unique:users,username,'.$user->id],
            'first_name' => ['filled', 'string'],
            'last_name' => ['filled', 'string'],
            'email' => ['filled', 'email', 'unique:users,email,'.$user->id],
            'password' => ['filled', 'confirmed'],
        ];
    }
}
