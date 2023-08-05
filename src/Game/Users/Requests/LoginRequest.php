<?php

namespace Emulator\Game\Users\Requests;

use Emulator\Api\Networking\Connections\IClient;
use Emulator\Game\Users\UserManager;

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

        return ($ticketLength >= 8 && $ticketLength <= 128) || empty($this->client);
    }

    public function getTicketLength(): int
    {
        return strlen($this->ticket);
    }

    public function attemptLogin(): bool
    {
        $user = UserManager::getInstance()->loadUser($this->ticket);
        
        if(empty($user)) return false;
        
        $this->client->setUser($user);
        $user->setClient($this->client);

        return true;
    }
}