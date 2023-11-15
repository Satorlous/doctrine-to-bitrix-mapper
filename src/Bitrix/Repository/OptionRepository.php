<?php

namespace App\Bitrix\Repository;

use App\Shared\Utils\Time;
use App\Bitrix\Entity\Option;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Option>
 *
 * @method Option|null find($id, $lockMode = null, $lockVersion = null)
 * @method Option|null findOneBy(array $criteria, array $orderBy = null)
 * @method Option[]    findAll()
 * @method Option[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Option::class);
    }

    public function get(string $moduleId, string $name, string $default = null): string
    {
        $record = $this->createQueryBuilder('o')
            ->select('o.value')
            ->where('o.moduleId = :module_id')
            ->andWhere('o.name = :name')
            ->setMaxResults(1)
            ->setParameters(
                new ArrayCollection([
                    new Parameter('module_id', $moduleId),
                    new Parameter('name', $name),
                ])
            )->getQuery()
            ->enableResultCache(Time::Hour->value)
            ->getOneOrNullResult();

        if (null !== $default) {
            return (string)$record['value'] ?: $default;
        }
        return (string)$record['value'];
    }
}
