<?php

namespace App\Repository\SavRetour;

use App\Entity\SavRetour\CommandeLigne;
use App\Entity\SavRetour\CommandeLigneSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

/**
 * @method CommandeLigne|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommandeLigne|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommandeLigne[]    findAll()
 * @method CommandeLigne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommandeLigneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommandeLigne::class);
    }

    private function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.date', 'DESC');
    }

    public function findAllVisibleQuery(CommandeLigneSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getCommande()){
            $query = $query
                ->innerJoin('c.commande', 'co')
                ->addSelect('co')
                ->andWhere('co.num_commande = :numCommande')
                ->setParameter('numCommande', $search->getCommande()->getNumCommande());
        }
        if ($search->getGencod()){
            $query = $query
                ->andWhere('c.gencod LIKE :value')
                ->setParameter('value', '%' . $search->getGencod() . '%');
        }
        if ($search->getEncours() === true){
            $query = $query
                ->andWhere('c.encours = :val')
                ->setParameter('val', $search->getEncours());
        } elseif ($search->getEncours() === "" ) {
            $query = $query
                ->andWhere('true = :val')
                ->setParameter('val', $search->getEncours());
        } elseif ($search->getEncours() === false) {
            $query = $query
                ->andWhere('c.encours = :val')
                ->setParameter('val', $search->getEncours());
        }

        return $query->getQuery();
    }

    public function findAllWithCmd()
    {
        $qb = $this->createQueryBuilder('cl')
            ->innerJoin('cl.commande', 'co' )
            ->addSelect('co')
            ->getQuery();

        return $qb->execute();
    }

    // /**
    //  * @return CommandeLigne[] Returns an array of CommandeLigne objects
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
    public function findOneBySomeField($value): ?CommandeLigne
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
