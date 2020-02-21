<?php

namespace App\Repository\SavRetour;

use App\Entity\SavRetour\CommandeLigneSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommandeLigneSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeLigneSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeLigneSearch[]    findAll()
 * @method CommandeLigneSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeLigneSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeLigneSearch::class);
    }

    // /**
    //  * @return CommandeLigneSearch[] Returns an array of CommandeLigneSearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CommandeLigneSearch
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
