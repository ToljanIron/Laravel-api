<?php

namespace App\Http\Requests\Auth;

use App\DataTransferObjects\LoginDTO;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email'    => 'required|email|exists:users,email',
            'password' => [
                'required',
                'min:8',
                'max:128',
                'regex:/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]+$/'
            ],
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Your password must contain one capital letter, 1 number and be longer than 8 characters.'
        ];
    }

    public function getDTO(): LoginDTO
    {
        return new LoginDTO(
            $this->input('email'),
            $this->input('password'),
        );
    }
}
