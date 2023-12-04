<?php

namespace App\Http\Requests\Auth;

use App\DataTransferObjects\RegisterDTO;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'password' => [
                'required',
                'min:8',
                'max:128',
                'regex:/^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]+$/'
            ],
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Your password must contain one capital letter, 1 number and be longer than 8 characters.'
        ];
    }

    public function getDTO(): RegisterDTO
    {
        return new RegisterDTO(
            $this->input('name'),
            $this->input('email'),
            $this->input('password'),
            $this->input('password_confirmation'),
        );
    }
}
