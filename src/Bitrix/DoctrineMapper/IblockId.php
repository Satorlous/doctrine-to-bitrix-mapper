<?php

namespace App\Bitrix\DoctrineMapper;

use Attribute;
use InvalidArgumentException;

#[Attribute(Attribute::TARGET_CLASS)]
class IblockId
{
    public function __construct(public int $id)
    {
        if ($this->id <= 0) {
            throw new InvalidArgumentException('Argument \"id\" must be greater than 0');
        }
    }
}
