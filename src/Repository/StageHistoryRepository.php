<?php

namespace App\Repository;

use App\Entity\StageHistory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method StageHistory|null find($id, $lockMode = null, $lockVersion = null)
 * @method StageHistory|null findOneBy(array $criteria, array $orderBy = null)
 * @method StageHistory[]    findAll()
 * @method StageHistory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StageHistoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StageHistory::class);
    }

    // /**
    //  * @return StageHistory[] Returns an array of StageHistory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StageHistory
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
