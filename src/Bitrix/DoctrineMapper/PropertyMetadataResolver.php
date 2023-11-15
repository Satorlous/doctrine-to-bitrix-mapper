<?php

namespace App\Bitrix\DoctrineMapper;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Mapping\MappingException;
use Psr\Log\LoggerInterface;

/**
 * @internal
 */
final class PropertyMetadataResolver
{
    private ClassMetadata $metadata;

    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly PropertyMapper  $propertyMapper,
    ) {
    }

    /**
     * @throws BitrixPropertyMapperException
     */
    public function resolve(ClassMetadata $metadata): void
    {
        if (!$reflClass = $metadata->getReflectionClass()) {
            return;
        }

        $this->metadata = $metadata;

        $mappedProperties = [];
        if ($reflClass->getAttributes(HasUnresolvedProperties::class)) {
            $mappedProperties = $this->propertyMapper->setReflectionClass($reflClass)->parseProperties();
        }
        foreach ($mappedProperties as $mappedProperty) {
            $this->resolveProperty($mappedProperty);
        }
    }

    private function resolveProperty(MappedProperty $mappedProperty): void
    {
        try {
            $fieldName    = $mappedProperty->reflProperty->getName();
            $dbColumnName = sprintf('PROPERTY_%s', $mappedProperty->propertyId);
            if ($mappedProperty->type === MappingTypeEnum::Field) {
                $overrideMapping['columnName'] = $dbColumnName;
                $this->metadata->setAttributeOverride($fieldName, $overrideMapping);
            }

            if ($mappedProperty->type === MappingTypeEnum::Association) {
                $overrideMapping = $this->metadata->getAssociationMapping($fieldName);
                $overrideMapping['joinColumns'][0]['name'] = $dbColumnName;
                $this->metadata->setAssociationOverride($fieldName, $overrideMapping);
            }
        } catch (MappingException $e) {
            $this->logger->warning($e->getMessage(), [
                'trace' => $e->getTrace(),
            ]);
        }
    }
}
