<?php

namespace App\Shared\JWT;

final class State
{
    private int $userId;
    private int $locationId;

    public function __construct(array $data = [])
    {
        $this->userId     = (int)$data['userId'];
        $this->locationId = (int)$data['locationId'];
    }

    public static function createFromPayload(array $payload): self
    {
        return new self([
            'userId'     => (int)$payload['uid'],
            'locationId' => (int)$payload['lid'],
        ]);
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getLocationId(): int
    {
        return $this->locationId;
    }
}
