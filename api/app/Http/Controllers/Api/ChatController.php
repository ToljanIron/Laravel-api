<?php

namespace App\Http\Controllers\Api;

use App\Events\MessageEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\Http\Resources\MessagePaginationResource;
use App\Services\ChatService;
use App\Traits\PusherTrait;


class ChatController extends Controller
{
    use PusherTrait;

    public function __construct(public ChatService $chatService){}

    public function create(int $id)
    {
        $chat = $this->chatService->createChat($id);
        $this->selectRecipients($chat, auth()->user(), 'create-new-chat', new ChatResource($chat), 'create-chat.');

        if ($chat) {
            return response()->json(['success' => new ChatResource($chat)], 201);
        }

        return response()->json(['error' => 'Chat error'], 500);
    }

    public function getChats() {
        $chats = $this->chatService->getChats();

        if ($chats) {
            return response()->json( ['success' => ChatResource::collection($chats)],201);
        }

        return response()->json( ['error' => 'Error chats'],500);
    }

    public function getChatById(int $id) {
        $dataChat = $this->chatService->getChatById($id);

        if ($dataChat) {
            return response()->json(["success"=> new MessagePaginationResource($dataChat)],201);
        }

        return response()->json(['error' => 'Error'], 404);
    }

    public function delete(int $id)
    {
        $chatDeleted = $this->chatService->delete($id);

        if ($chatDeleted) {
            return response()->json(["success"=> 'Chat successfully deleted'],201);
        }

        return response()->json(['message' => 'Not found'], 404);
    }


}
