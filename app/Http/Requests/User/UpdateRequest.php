<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateRequest extends FormRequest
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
    public function rules($id = null): array
    {
        $id = $id ?? $this->id;
        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'max:255',
                'string',
                'regex:/^(?!.*__)[a-z0-9_]+(?<!_)$/',
                Rule::unique('users', 'username')->ignore($id),
            ],
            'email' => [
                'required',
                'email',
                'email:rfc,dns',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'phone_number' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'min:10',
                'max:13',
                Rule::unique('users', 'phone_number')->ignore($id),
            ],
            'role' => ['required', 'integer', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:8'],
            'dob' => ['nullable', 'date'],
            'zip' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'username.regex' => 'Username must contain only lowercase letters, numbers, and underscores, and cannot start or end with an underscore.',
        ];
    }
}
