<?php

namespace App\Repository;

use App\Entity\ActionHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ActionHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionHistory[]    findAll()
 * @method ActionHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionHistory::class);
    }

    // /**
    //  * @return ActionHistory[] Returns an array of ActionHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ActionHistory
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
