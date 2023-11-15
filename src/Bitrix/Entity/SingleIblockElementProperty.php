<?php

namespace App\Bitrix\Entity;

use Doctrine\ORM\Mapping as ORM;

class SingleIblockElementProperty
{
    #[ORM\Id]
    #[ORM\Column(name: 'IBLOCK_ELEMENT_ID', type: 'integer', nullable: false)]
    protected ?int $elementId = null;

    public function getElementId(): ?int
    {
        return $this->elementId;
    }
}
