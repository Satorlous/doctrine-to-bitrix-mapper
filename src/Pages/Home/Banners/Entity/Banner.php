<?php

namespace App\Pages\Home\Banners\Entity;

use App\Bitrix\Entity\IblockElement;
use App\Pages\Home\Banners\Repository\BannerRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BannerRepository::class)]
class Banner extends IblockElement
{
    #[ORM\OneToOne(mappedBy: 'banner', targetEntity: BannerOption::class)]
    private ?BannerOption $option = null;

    /** @var Collection<BannerIblockElementProperty>|null  */
    #[ORM\OneToMany(mappedBy: 'banner', targetEntity: BannerIblockElementProperty::class)]
    private ?Collection $properties = null;

    public function getOption(): ?BannerOption
    {
        return $this->option;
    }

    public function getProperties(): ?Collection
    {
        return $this->properties;
    }
}
