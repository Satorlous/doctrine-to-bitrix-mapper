<?php

namespace App\Bitrix\DoctrineMapper;

use Doctrine\ORM\Mapping\Column;
use ReflectionAttribute;
use ReflectionProperty;

/**
 * @internal
 */
final readonly class MappedProperty
{
    public MappingTypeEnum $type;

    public function __construct(
        public ReflectionProperty $reflProperty,
        ReflectionAttribute       $association,
        public int                $propertyId,
    ) {
        $this->type = $association->getName() === Column::class
            ? MappingTypeEnum::Field
            : MappingTypeEnum::Association;
    }
}
