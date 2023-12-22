<?php

namespace App\Services;

use App\DataTransferObjects\SendTextMessageDTO;
use App\DataTransferObjects\UpdateTextMessageDTO;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Traits\PusherTrait;

class MessageService
{
    use PusherTrait;

    public function send(SendTextMessageDTO $dto)
    {
        $chat = Chat::findOrFail($dto->chat_id);

        if($chat->userBelongsToChat(auth()->user())){

            $message = Message::create([
                'content' => $dto->content,
                'chat_id' => $dto->chat_id,
                'user_id' => auth()->user()->id,
            ]);

            $this->selectRecipients($chat, auth()->user(), 'message-send', new MessageResource($message), 'chat-channel.');

            return $message;
        }

        return false;
    }

    public function update(int $id, UpdateTextMessageDTO $dto)
    {
        $message = Message::findOrFail($id);

        if ($message->isOwnedByUser(auth()->user()->id)) {
            $message->update([
                'content' => $dto->content,
            ]);

            $this->selectRecipients($message->chat, auth()->user(), 'message-update', $message, 'chat-channel.');

            return $message;
        }

        return false;
    }

    public function delete(int $id)
    {
        $message = Message::findOrFail($id);

        if ($message->isOwnedByUser(auth()->user()->id)) {
            $message->delete();

            $this->selectRecipients($message->chat, auth()->user(), 'message-delete', ['id' => $id], 'chat-channel.');

            return true;
        }

        return false;
    }
}
