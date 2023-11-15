<?php

namespace App\Bitrix\Entity;

use App\Bitrix\Repository\IblockPropertyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'b_iblock_property')]
#[ORM\Entity(repositoryClass: IblockPropertyRepository::class)]
class IblockProperty
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'ID')]
    private ?int $id = null;

    #[ORM\Column(name: 'IBLOCK_ID')]
    private ?int $iblockId = null;

    #[ORM\Column(name: 'NAME', length: 255)]
    private ?string $name = null;

    #[ORM\Column(name: 'CODE', length: 50, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(name: 'ACTIVE', length: 1, options: [
        'default' => 'Y',
    ])]
    private ?string $isActive = null;

    #[ORM\Column(name: 'PROPERTY_TYPE', length: 1, options: [
        'default' => 'S',
    ])]
    private ?string $type = null;

    #[ORM\Column(name: 'MULTIPLE', length: 1, options: [
        'default' => 'N',
    ])]
    private ?string $isMultiple = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIblockId(): ?int
    {
        return $this->iblockId;
    }

    public function setIblockId(int $iblockId): static
    {
        $this->iblockId = $iblockId;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;
        return $this;
    }

    public function isActive(): ?string
    {
        return match ($this->isActive) {
            'Y' => true,
            default => false,
        };
    }

    public function setActive(bool $isActive = true): static
    {
        $this->isActive = match ($isActive) {
            true => 'Y',
            false => 'N',
        };
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getIsMultiple(): ?string
    {
        return match ($this->isMultiple) {
            'Y' => true,
            default => false,
        };
    }

    public function setMultiple(bool $isMultiple = true): static
    {
        $this->isMultiple = match ($isMultiple) {
            true => 'Y',
            false => 'N'
        };
        return $this;
    }
}
