<?php

namespace App\Repository;

use App\Entity\CT;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CT>
 *
 * @method CT|null find($id, $lockMode = null, $lockVersion = null)
 * @method CT|null findOneBy(array $criteria, array $orderBy = null)
 * @method CT[]    findAll()
 * @method CT[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CTRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CT::class);
    }

//    /**
//     * @return CT[] Returns an array of CT objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?CT
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
