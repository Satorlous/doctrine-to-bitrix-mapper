<?php

namespace App\Pages\Home\Banners\Entity;

use App\Bitrix\Entity\MultipleIblockElementProperty;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'b_iblock_element_prop_m50')]
class BannerIblockElementProperty extends MultipleIblockElementProperty
{
    #[ORM\ManyToOne(targetEntity: Banner::class, inversedBy: 'properties')]
    #[ORM\JoinColumn(name: 'IBLOCK_ELEMENT_ID', referencedColumnName: 'ID')]
    private ?Banner $banner = null;

    public function getBanner(): ?Banner
    {
        return $this->banner;
    }
}
