<?php

namespace App\Pages\Home\Banners\Entity;

use App\Bitrix\DoctrineMapper\BitrixProperty;
use App\Bitrix\DoctrineMapper\HasUnresolvedProperties;
use App\Bitrix\DoctrineMapper\IblockId;
use App\Bitrix\Entity\EnumProperty;
use App\Bitrix\Entity\File;
use App\Bitrix\Entity\SingleIblockElementProperty;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[IblockId(50)]
#[HasUnresolvedProperties]
#[ORM\Table('`b_iblock_element_prop_s50`')]
class BannerOption extends SingleIblockElementProperty
{
    #[BitrixProperty(code: 'LINK')]
    #[ORM\Column]
    private ?string $link = null;

    #[BitrixProperty('KAM_DETAIL_PICTURE')]
    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(referencedColumnName: 'ID')]
    private ?File $desktopImage = null;

    #[BitrixProperty('KAM_PREVIEW_PICTURE')]
    #[ORM\OneToOne(targetEntity: File::class)]
    #[ORM\JoinColumn(referencedColumnName: 'ID')]
    private ?File $mobileImage = null;

    #[BitrixProperty('KAM_DOT_COLOR')]
    #[ORM\OneToOne(targetEntity: EnumProperty::class)]
    #[ORM\JoinColumn(referencedColumnName: 'ID')]
    private ?EnumProperty $color = null;

    #[ORM\OneToOne(inversedBy: 'option', targetEntity: Banner::class)]
    #[ORM\JoinColumn(name: 'IBLOCK_ELEMENT_ID', referencedColumnName: 'ID')]
    private ?Banner $banner = null;

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function getDesktopImage(): ?File
    {
        return $this->desktopImage;
    }

    public function getMobileImage(): ?File
    {
        return $this->mobileImage;
    }

    public function getColor(): ?EnumProperty
    {
        return $this->color;
    }

    public function getBanner(): ?Banner
    {
        return $this->banner;
    }
}
