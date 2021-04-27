<?php

namespace App\Repository;

use App\Entity\Vehicule;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vehicule|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vehicule|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vehicule[]    findAll()
 * @method Vehicule[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VehiculeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vehicule::class);
    }

    /**
     * @return Vehicule[] Returns an array of Vehicule objects
     */
    
    public function findVehiculeSoldByInterval($from, $to)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.dateVente >= :from')
            ->setParameter('from', $from)
            ->andWhere('l.dateVente <= :to')
            ->setParameter('to', $to)
            ->andWhere('l.status = 2')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findVehiculesAchatByInterval($from, $to)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.dataAchat >= :from')
            ->setParameter('from', $from)
            ->andWhere('l.dataAchat <= :to')
            ->setParameter('to', $to)
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findVehiculesActiveCountByInterval($from, $to)
    {
        return count(
            $this->createQueryBuilder('l')
            // ->andWhere('l.dataAchat >= :from')
            // ->setParameter('from', $from)
            ->andWhere('l.dataAchat <= :to')
            ->setParameter('to', $to)
            ->andWhere('l.status != 2')
            ->getQuery()
            ->getResult()
        );
    }
    

    /*
    public function findOneBySomeField($value): ?Vehicule
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
