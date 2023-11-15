<?php

namespace App\Bitrix\Entity;

use App\Bitrix\Repository\OptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OptionRepository::class)]
#[ORM\Table(name: '`b_option`')]
class Option
{
    #[ORM\Id, ORM\Column(length: 50)]
    private ?string $moduleId = null;

    #[ORM\Id, ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $value = null;

    public function getModuleId(): ?string
    {
        return $this->moduleId;
    }

    public function setModuleId(string $moduleId): static
    {
        $this->moduleId = $moduleId;

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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(?string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
