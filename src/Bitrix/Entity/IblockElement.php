<?php

namespace App\Bitrix\Entity;

use App\Pages\Home\Banners\Entity\Banner;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'IBLOCK_ID', type: 'integer')]
#[ORM\DiscriminatorMap([
    50 => Banner::class,
    51 => File::class,
])]
#[ORM\Table(name: 'b_iblock_element')]
class IblockElement
{
    #[ORM\Id, ORM\GeneratedValue]
    #[ORM\Column(name: 'ID', type: 'integer')]
    protected ?int $id = null;

    #[ORM\Column(name: 'ACTIVE', type: 'string')]
    protected ?string $active = null;

    #[ORM\Column(name: 'NAME', type: 'string')]
    protected ?string $name = null;

    #[ORM\Column(name: 'CODE', type: 'string')]
    protected ?string $code = null;

    #[ORM\Column(name: 'SORT', type: 'integer')]
    protected ?int $sort = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getActive(): ?string
    {
        return $this->active;
    }

    public function setActive(?string $active): IblockElement
    {
        $this->active = $active;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): IblockElement
    {
        $this->name = $name;
        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): IblockElement
    {
        $this->code = $code;
        return $this;
    }

    public function getSort(): ?int
    {
        return $this->sort;
    }

    public function setSort(?int $sort): IblockElement
    {
        $this->sort = $sort;
        return $this;
    }
}
