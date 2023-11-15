<?php

namespace App\Bitrix\Repository;

use App\Bitrix\Entity\IblockProperty;
use App\Bitrix\Enum\IblockEnum;
use App\Shared\Utils\Time;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<IblockProperty>
 *
 * @method IblockProperty|null find($id, $lockMode = null, $lockVersion = null)
 * @method IblockProperty|null findOneBy(array $criteria, array $orderBy = null)
 * @method IblockProperty[]    findAll()
 * @method IblockProperty[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IblockPropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IblockProperty::class);
    }

    public function getIdByCodeAndIblockId(string $code, IblockEnum | int $iblockId): ?int
    {
        $iblockIdValue = is_int($iblockId) ? $iblockId : $iblockId->value;
        $result        = $this->createQueryBuilder('p')
            ->select('p.id')
            ->where('p.code = :code')
            ->andWhere('p.iblockId = :iblockId')
            ->setParameters([
                'code'     => $code,
                'iblockId' => $iblockIdValue,
            ])
            ->setMaxResults(1)
            ->getQuery()
            ->enableResultCache(Time::Hour->value)
            ->getOneOrNullResult();
        return $result['id'] ?? null;
    }
}
