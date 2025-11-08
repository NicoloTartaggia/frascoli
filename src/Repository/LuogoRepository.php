<?php

namespace App\Repository;

use App\Entity\Luogo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Luogo>
 *
 * @method Luogo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Luogo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Luogo[]    findAll()
 * @method Luogo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LuogoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Luogo::class);
    }

//    /**
//     * @return Luogo[] Returns an array of Luogo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Luogo
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
