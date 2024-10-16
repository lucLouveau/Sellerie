<?php

namespace App\Repository;

use App\Entity\Historiques;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Historiques>
 */
class HistoriquesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Historiques::class);
    }

    public function findAllByDate($date){
        return $this->createQueryBuilder('h')
            ->where('h.date BETWEEN :startDate AND :endDate')
            ->setParameter('startDate', $date.' 00:00:00')
            ->setParameter('endDate', $date.' 23:59:59')
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Historiques[] Returns an array of Historiques objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('h.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Historiques
    //    {
    //        return $this->createQueryBuilder('h')
    //            ->andWhere('h.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
