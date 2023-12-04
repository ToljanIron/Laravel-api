<?php

namespace App\Http\Requests\Address;

use App\DataTransferObjects\CreateUserAddressDTO;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserAddressRequest extends FormRequest
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
            'address_line_1' => 'required|string|max:255',
            'state' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
        ];
    }

    public function getDTO(): CreateUserAddressDTO
    {
        return new CreateUserAddressDTO(
            $this->input('address_line_1'),
            $this->input('state'),
            $this->input('city'),
            $this->input('zip'),
            $this->input('phone'),
        );
    }
}
