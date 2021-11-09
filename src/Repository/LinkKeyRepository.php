<?php

namespace App\Repository;

use App\Entity\LinkKey;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LinkKey|null find($id, $lockMode = null, $lockVersion = null)
 * @method LinkKey|null findOneBy(array $criteria, array $orderBy = null)
 * @method LinkKey[]    findAll()
 * @method LinkKey[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkKeyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkKey::class);
    }

    // /**
    //  * @return LinkKey[] Returns an array of LinkKey objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LinkKey
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
