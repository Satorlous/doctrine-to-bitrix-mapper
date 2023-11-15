<?php

namespace App\Shared\Utils;

final readonly class FileDomainLocator
{
    public function __construct(
        private string $domain
    ) {
    }

    public function get(?string $uri = ''): string
    {
        return $uri ? $this->domain . $uri : '';
    }
}
