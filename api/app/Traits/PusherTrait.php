<?php

namespace App\Traits;

use GuzzleHttp\Exception\GuzzleException;
use Pusher\ApiErrorException;
use Pusher\Pusher;
use Pusher\PusherException;

trait PusherTrait
{
    /**
     * @throws PusherException
     * @throws ApiErrorException
     * @throws GuzzleException
     */
    private function triggerPusherEvent($channel, $event, $data)
    {
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true,
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        return $pusher->trigger($channel, $event, $data);

    }

    private function selectRecipients($chat, $user, $event, $data, $channel)
    {
        $recipients = $chat->users->where('id', '!=', $user->id)->pluck('id')->toArray();

        foreach ($recipients as $recipientId) {
            $this->triggerPusherEvent($channel . $recipientId, $event, $data);
        }
    }
}
