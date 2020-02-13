<?php

namespace App\Repository\SavRetour;

use App\Entity\SavRetour\Picking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Picking|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picking|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picking[]    findAll()
 * @method Picking[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PickingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picking::class);
    }

    // /**
    //  * @return Picking[] Returns an array of Picking objects
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
    public function findOneBySomeField($value): ?Picking
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
