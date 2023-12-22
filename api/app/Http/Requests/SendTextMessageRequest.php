<?php

namespace App\Http\Requests;

use App\DataTransferObjects\SendTextMessageDTO;
use Illuminate\Foundation\Http\FormRequest;

class SendTextMessageRequest extends FormRequest
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
            'chat_id' => 'required|numeric|exists:chats,id',
            'content' => 'required|string|min:1|max:255'
        ];
    }

    public function getDTO(): SendTextMessageDTO
    {
        return new SendTextMessageDTO(
            $this->input('chat_id'),
            $this->input('content'),
        );
    }
}
