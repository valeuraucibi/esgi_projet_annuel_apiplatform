<?php

namespace App\Repository;

use App\Entity\PaymentResult;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PaymentResult|null find($id, $lockMode = null, $lockVersion = null)
 * @method PaymentResult|null findOneBy(array $criteria, array $orderBy = null)
 * @method PaymentResult[]    findAll()
 * @method PaymentResult[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PaymentResultRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PaymentResult::class);
    }

    // /**
    //  * @return PaymentResult[] Returns an array of PaymentResult objects
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
    public function findOneBySomeField($value): ?PaymentResult
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
