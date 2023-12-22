<?php

namespace App\Services;

use App\Models\Chat;
use App\Models\User;

class ChatService
{
    public function getChats()
    {
        return auth()->user()->chats()->get();
    }

    public function getChatById(int $id)
    {
        $chat = Chat::find($id);

        if($chat->userBelongsToChat(auth()->user())){

            return $chat->messages()->orderBy('created_at','asc')->paginate(100);
        }

        return false;
    }

    public function createChat(int $id)
    {
        if ($id === auth()->user()->id) {
            throw new \Exception('Cannot create a chat room with yourself', 400);
        }

        $contactUser = User::findOrFail($id);

        return auth()->user()->getOrCreateChatWith($contactUser);
    }

    public function delete(int $id)
    {
        $chat = Chat::findOrFail($id);

        if ($chat->userBelongsToChat(auth()->user())){
            return $chat->delete();
        }

        return false;
    }
}
