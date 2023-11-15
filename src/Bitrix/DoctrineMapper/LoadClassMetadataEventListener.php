<?php

namespace App\Bitrix\DoctrineMapper;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Events;

#[AsDoctrineListener(event: Events::loadClassMetadata, connection: 'bitrix')]
final readonly class LoadClassMetadataEventListener
{
    public function __construct(
        private PropertyMetadataResolver $resolver
    ) {
    }

    /**
     * @throws BitrixPropertyMapperException
     */
    public function __invoke(LoadClassMetadataEventArgs $args): void
    {
        $this->resolver->resolve($args->getClassMetadata());
    }
}
