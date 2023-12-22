<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendTextMessageRequest;
use App\Http\Requests\UpdateTextMessageRequest;
use App\Http\Resources\MessageResource;
use App\Services\MessageService;

class MessageController extends Controller
{
    public function __construct(public MessageService $messageService){}

    public function send(SendTextMessageRequest $request){
        $message = $this->messageService->send($request->getDTO());

        if ($message) {
            return response()->json(["success"=> new MessageResource($message)],201);
        }

        return response()->json(['message' => 'Not found'], 404);
    }

    public function update(UpdateTextMessageRequest $request, int $id)
    {
        $message = $this->messageService->update($id, $request->getDTO());

        if ($message) {
            return response()->json(["success"=> 'Message updated successfully'],201);
        }

        return response()->json(['message' => 'Not found'], 404);
    }

    public function delete(int $id)
    {
        $message = $this->messageService->delete($id);

        if ($message) {
            return response()->json(["success"=> 'Message successfully deleted'],201);
        }

        return response()->json(['message' => 'Not found'], 404);
    }
}
