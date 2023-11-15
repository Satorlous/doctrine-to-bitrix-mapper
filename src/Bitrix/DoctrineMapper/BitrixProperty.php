<?php

namespace App\Bitrix\DoctrineMapper;

use Attribute;
use InvalidArgumentException;

#[Attribute(Attribute::TARGET_PROPERTY)]
class BitrixProperty
{
    public function __construct(
        public string $code,
        public ?int   $iblockId = null,
    ) {
        if ($this->code === '') {
            throw new InvalidArgumentException('Argument \"code\" must not be empty');
        }
    }
}
