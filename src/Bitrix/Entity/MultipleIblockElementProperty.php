<?php

namespace App\Bitrix\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
class MultipleIblockElementProperty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'ID', type: 'integer', nullable: false)]
    protected ?int $id = null;

    #[ORM\Column(name: 'IBLOCK_ELEMENT_ID', type: 'integer', nullable: false)]
    protected ?int $elementId = null;

    #[ORM\Column(name: 'IBLOCK_PROPERTY_ID', type: 'integer', nullable: false)]
    protected ?int $propertyId = null;

    #[ORM\Column(name: 'VALUE', type: 'text', nullable: false)]
    protected ?string $value = null;

    #[ORM\Column(name: 'DESCRIPTION', type: 'text', nullable: true)]
    protected ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getElementId(): ?int
    {
        return $this->elementId;
    }

    public function setElementId(?int $elementId): MultipleIblockElementProperty
    {
        $this->elementId = $elementId;
        return $this;
    }

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    public function setPropertyId(?int $propertyId): MultipleIblockElementProperty
    {
        $this->propertyId = $propertyId;
        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): MultipleIblockElementProperty
    {
        $this->value = $value;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): MultipleIblockElementProperty
    {
        $this->description = $description;
        return $this;
    }
}
