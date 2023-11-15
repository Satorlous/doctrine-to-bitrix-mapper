<?php

namespace App\Bitrix\DoctrineMapper;

use App\Bitrix\Repository\IblockPropertyRepository;
use App\Shared\Utils\AttributeHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\JoinColumn;
use ReflectionAttribute;
use ReflectionClass;

/**
 * @internal
 */
final class PropertyMapper
{
    private ?int $iblockId;

    public ReflectionClass $reflClass;

    public function __construct(
        private readonly IblockPropertyRepository $propertyRepository
    ) {
    }

    public function setReflectionClass(ReflectionClass $reflectionClass): PropertyMapper
    {
        $this->reflClass = $reflectionClass;
        return $this;
    }

    /**
     * @return array<MappedProperty>
     * @throws BitrixPropertyMapperException
     */
    public function parseProperties(): array
    {
        $mapped = [];
        foreach ($this->reflClass->getProperties() as $reflProperty) {
            $attributes = new ArrayCollection($reflProperty->getAttributes());
            if ($attributes->isEmpty()) {
                continue;
            }
            if (!$guessed = $this->guessMapping($attributes)) {
                continue;
            }
            [$association, $bitrixPropertyCode, $iblockId] = $guessed;
            $iblockId ??= $this->getIblockIdFromClass();
            if (!$iblockId) {
                throw new BitrixPropertyMapperException(
                    sprintf(
                        'Iblock ID must be defined in entity mapping either as #[%s], or an argument of #[%s]. Caused in "%s".',
                        IblockId::class,
                        BitrixProperty::class,
                        $this->reflClass->getName()
                    )
                );
            }
            $mapped[] = new MappedProperty(
                $reflProperty,
                $association,
                $this->propertyRepository->getIdByCodeAndIblockId($bitrixPropertyCode, $iblockId)
            );
        }
        return $mapped;
    }

    private function guessMapping(ArrayCollection $attributes): array | false
    {
        $associationAttribute    = null;
        $bitrixPropertyAttribute = null;
        /** @var ReflectionAttribute $attribute */
        foreach ($attributes as $attribute) {
            if (in_array($attribute->getName(), [JoinColumn::class, Column::class])) {
                $associationAttribute = $attribute;
            }
            if ($attribute->getName() === BitrixProperty::class) {
                $bitrixPropertyAttribute = $attribute;
            }
        }
        if (!$associationAttribute === null || $bitrixPropertyAttribute === null) {
            return false;
        }
        $args       = $bitrixPropertyAttribute->getArguments();
        $bxPropCode = (string)($args['code'] ?? current($args));
        $iblockId   = (int)(AttributeHelper::extractArgument($args, 'iblockId', 2)) ?: null;
        return [$associationAttribute, $bxPropCode, $iblockId];
    }

    private function getIblockIdFromClass(): ?int
    {
        if (isset($this->iblockId)) {
            return $this->iblockId;
        }
        $classAttributes   = new ArrayCollection($this->reflClass->getAttributes());
        $iblockIdAttribute = $classAttributes->findFirst(
            static fn($k, ReflectionAttribute $attribute) => $attribute->getName() === IblockId::class
        );
        $classIblockId     = null;
        if ($iblockIdAttribute) {
            $args          = $iblockIdAttribute->getArguments();
            $classIblockId = (int)(AttributeHelper::extractArgument($args, 'id', 1));
        }
        return $this->iblockId = $classIblockId;

    }
}
