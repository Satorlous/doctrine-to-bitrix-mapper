<?php

namespace App\Pages\Home\Banners\Service;

use App\Pages\Home\Banners\Entity\Banner;
use App\Pages\Home\Banners\Repository\BannerRepository;

final class BannerService
{
    private int $userLocationId;

    public function __construct(
        private readonly BannerRepository $repository
    ) {
    }

    public function setLocationId(int $userLocationId): BannerService
    {
        $this->userLocationId = $userLocationId;
        return $this;
    }

    public function get(): array
    {
        return $this->format($this->repository->getByLocation($this->userLocationId));
    }

    public function getFirst(): array
    {
        return $this->format($this->repository->getFirst());
    }

    /**
     * @param array<Banner> $banners
     * @return array
     */
    private function format(array $banners): array
    {
        $resultData = [];
        foreach ($banners as $banner) {
            $resultData[] = [
                'image' => [
                    'desktop' => $banner->getOption()?->getDesktopImage()?->getPath(),
                    'mobile'  => $banner->getOption()?->getMobileImage()?->getPath(),
                ],
                'color' => $banner->getOption()?->getColor()?->getXmlId(),
                'title' => $banner->getName(),
                'url'   => $banner->getOption()?->getLink(),
            ];
        }

        return $resultData;
    }
}
