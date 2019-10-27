<?php

namespace App\Repository;

use App\Entity\Plant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Plant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plant[]    findAll()
 * @method Plant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plant::class);
    }

    // /**
    //  * @return Plant[] Returns an array of Plant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Plant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /*
    SELECT *
    FROM `plant`as p
    INNER JOIN `action_history` as ah
    ON p.id = ah.id_plant_id
    INNER JOIN `action` as a
    ON a.id = ah.id_action_id
    WHERE p.id = 25 AND a.name LIKE 'water%'
    ORDER BY ah.date DESC
    LIMIT 1;
    */

    public function getLastTimeWatered($idPlant){
        $actionName = 'Watering';

        $query = $this->createQueryBuilder('p')
            ->select('ah.date')
            ->innerJoin(ActionHistory::class, 'ah', 'WITH', 'p.id = ah.id_plant')
            ->innerJoin(Action::class, 'a', 'WITH', 'a.id = ah.id_action')
            ->orderBy('ah.date', 'DESC')
            ->where('p.id = :plantid AND a.name = :actionname')
            ->setParameter('actionname',  $actionName)
            ->setParameter('plantid', $idPlant)
            ->setMaxResults(1)
            ->getQuery();
        //return  $query;
        $result= $query->getResult();
        return  $result;
    }
}
