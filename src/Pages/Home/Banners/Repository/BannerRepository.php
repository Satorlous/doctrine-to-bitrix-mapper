<?php

namespace App\Pages\Home\Banners\Repository;

use App\Bitrix\Enum\IblockEnum;
use App\Bitrix\Repository\IblockPropertyRepository;
use App\Pages\Home\Banners\Entity\Banner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Banner>
 *
 * @method Banner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Banner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Banner[]    findAll()
 * @method Banner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BannerRepository extends ServiceEntityRepository
{
    public function __construct(
        ManagerRegistry                           $registry,
        private readonly IblockPropertyRepository $iblockPropertyRepository,
    ) {
        parent::__construct($registry, Banner::class);
    }

    /**
     * @param int $locationId
     * @return array<Banner>
     */
    public function getByLocation(int $locationId): array
    {
        $qb = $this->getPreparedQueryBuilder();
        $e  = $qb->expr();
        return $qb
            ->where(
                $e->andX(
                    $e->eq('banner.active', ':active'),
                    $e->orX(
                        $e->eq('location.value', ':currentLocation'),
                        $e->isNull('location.value')
                    ),
                    $e->orX(
                        $e->neq('hideLocation.value', ':currentLocation'),
                        $e->isNull('hideLocation.value')
                    ),
                )
            )
            ->setParameter('currentLocation', $locationId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return array<Banner>
     */
    public function getFirst(): array
    {
        $qb = $this->getPreparedQueryBuilder();
        $e  = $qb->expr();
        return $qb
            ->where(
                $e->andX(
                    $e->eq('banner.active', ':active'),
                    $e->isNull('location.value'),
                    $e->isNull('hideLocation.value'),
                )
            )
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

    private function getPreparedQueryBuilder(): QueryBuilder
    {
        return $this->createQueryBuilder('banner')
            ->select('banner', 'option', 'desktopImage', 'mobileImage', 'color')
            ->where('banner.active = :active')
            ->orderBy('banner.sort', 'ASC')
            ->leftJoin('banner.option', 'option')
            ->leftJoin('option.desktopImage', 'desktopImage')
            ->leftJoin('option.mobileImage', 'mobileImage')
            ->leftJoin('option.color', 'color')
            ->leftJoin(
                'banner.properties',
                'location',
                Join::WITH,
                'location.propertyId = :locationPropertyId'
            )
            ->leftJoin(
                'banner.properties',
                'hideLocation',
                Join::WITH,
                'hideLocation.propertyId = :hideInLocationPropertyId'
            )
            ->setParameters([
                'active'                   => 'Y',
                'locationPropertyId'       => $this->iblockPropertyRepository->getIdByCodeAndIblockId(
                    'LOCATION',
                    IblockEnum::HomeBanners
                ),
                'hideInLocationPropertyId' => $this->iblockPropertyRepository->getIdByCodeAndIblockId(
                    'HIDE_IN_REGION',
                    IblockEnum::HomeBanners
                ),
            ]);

    }
}
