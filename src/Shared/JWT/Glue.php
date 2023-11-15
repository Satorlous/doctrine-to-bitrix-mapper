<?php

namespace App\Shared\JWT;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

final class Glue
{
    private const KEY = '123';
    private const ALG = 'HS256';

    public function getState(string $token): State
    {
        $payload = (array)JWT::decode($token, new Key(self::KEY, self::ALG));
        return State::createFromPayload($payload);
    }
}
