<?php

namespace Emulator\Game\Users\Requests;

use Emulator\Api\Networking\Connections\IClient;

class LoginRequest
{
    public function __construct(
        private readonly IClient $client,
        private readonly string $ticket
    ) {
        
    }

    public function isValid(): bool
    {
        $ticketLength = $this->getTicketLength();

        return $ticketLength >= 8 && $ticketLength <= 128;
    }

    public function getTicketLength(): int
    {
        return strlen($this->ticket);
    }

    public function attemptLogin(): bool
    {
        // TODO: Implement login attempt
        return true;
    }
}