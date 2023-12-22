<?php

namespace App\DataTransferObjects;

class UpdateTextMessageDTO
{
    public function __construct(
        public readonly string $content,
    )
    {}
}
