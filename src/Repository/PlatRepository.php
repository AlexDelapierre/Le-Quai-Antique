<?php

namespace App\Repository;

use App\Entity\Plat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Plat>
 *
 * @method Plat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plat[]    findAll()
 * @method Plat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Plat::class);
    }

    public function save(Plat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Plat $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    // public function findAllOrderByCategoryAsc()
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT p
    //         FROM App\Entity\Plat p
    //         ORDER BY p.category ASC'
    //     );

    //     return $query->getResult();
    // }

    //Requête pour tout récupérer avec join
    public function findAll()
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.category', 'c')
            ->addSelect('c')
            ->getQuery()
            ->getResult();
    }

 
    // Requête pour récupérer tous les plats avec la category 'Entrées'
    public function findAllEntreesOrderedByAsc()
    {
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :category')
            ->setParameter('category', 'Entrées')
            ->orderBy('p.title', 'ASC')
            ->getQuery()
            ->getResult();
    }

   // Requête pour récupérer tous les plats avec la category 'plats'
    public function findAllPlatsOrderedByAsc()
    {
        return $this->createQueryBuilder('p')
        ->join('p.category', 'c')
        ->andWhere('c.name = :category')
        ->setParameter('category', 'plats')
        ->orderBy('p.title', 'ASC')
        ->getQuery()
        ->getResult();
    }

    // Requête pour récupérer tous les plats avec la category 'Desserts'
    public function findAllDessertsOrderedByAsc()
    {
        return $this->createQueryBuilder('p')
            ->join('p.category', 'c')
            ->andWhere('c.name = :category')
            ->setParameter('category', 'Desserts')
            ->orderBy('p.title', 'ASC')
            ->getQuery()
            ->getResult();
    }




//    /**
//     * @return Plat[] Returns an array of Plat objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Plat
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}