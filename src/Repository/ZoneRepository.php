<?php

namespace App\Repository;

use App\Entity\Zone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Zone>
 */
class ZoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Zone::class);
    }

    public function findAllNotId($id){
        return $this->createQueryBuilder('z')
            ->where('z.id != :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findEquipementInZone(int $zoneId): array{
        return $this->createQueryBuilder('z')
            ->select('e.id AS equipement_id, e.nom, z.nom AS zone_nom, h.date,m.nom AS mouvement_nom')
            ->join('z.historiques', 'h') // Relation entre Zone et Historique
            ->join('h.equipement', 'e')
            ->join('h.mouvement', 'm')  // Relation entre Historique et Equipement
            ->where('z.id = :zoneId')    // Filtrer par l'ID de la zone
            ->andWhere('h.date = (
                SELECT MAX(h2.date)
                FROM App\Entity\Historiques h2
                WHERE h2.equipement = h.equipement
            )')
            ->andWhere('m.nom != :retour')
            ->setParameter('zoneId', $zoneId)
            ->setParameter('retour', 'retour')
            ->orderBy('e.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return Zone[] Returns an array of Zone objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('z')
    //            ->andWhere('z.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('z.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Zone
    //    {
    //        return $this->createQueryBuilder('z')
    //            ->andWhere('z.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
