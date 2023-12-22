<?php

namespace App\DataTransferObjects;

class SendTextMessageDTO
{
    public function __construct(
        public readonly int $chat_id,
        public readonly string $content,
    )
    {}
}
