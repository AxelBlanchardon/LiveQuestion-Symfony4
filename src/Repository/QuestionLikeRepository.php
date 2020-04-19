<?php

namespace App\Repository;

use App\Entity\QuestionLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionLike[]    findAll()
 * @method QuestionLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionLike::class);
    }

    // /**
    //  * @return QuestionLike[] Returns an array of QuestionLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionLike
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
