<?php

namespace App\Bitrix\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'b_iblock_property_enum')]
class EnumProperty
{
    #[ORM\Id, ORM\GeneratedValue]
    #[ORM\Column(name: 'ID')]
    private ?int $id = null;

    #[ORM\Column(name: 'PROPERTY_ID')]
    private ?int $propertyId = null;

    #[ORM\Column(name: 'VALUE', length: 255)]
    private ?string $value = null;

    #[ORM\Column(name: 'DEF', type: 'string', length: 1, options: [
        'default' => 'N',
    ])]
    private ?string $isDefault = null;

    #[ORM\Column(name: 'SORT')]
    private ?int $sort = null;

    #[ORM\Column(name: 'XML_ID', length: 200)]
    private ?string $xmlId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPropertyId(): ?int
    {
        return $this->propertyId;
    }

    public function setPropertyId(int $propertyId): static
    {
        $this->propertyId = $propertyId;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function isDefault(): ?bool
    {
        return $this->isDefault === 'Y';
    }

    public function setIsDefault(bool $isDefault): static
    {
        $this->isDefault = match ($isDefault) {
            true => 'Y',
            false => 'N'
        };
        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(int $sort): static
    {
        $this->sort = $sort;
        return $this;
    }

    public function getXmlId(): ?string
    {
        return $this->xmlId;
    }

    public function setXmlId(string $xmlId): static
    {
        $this->xmlId = $xmlId;
        return $this;
    }
}
