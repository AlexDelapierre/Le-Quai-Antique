<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function save(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Reservation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Reservation[] Returns an array of Reservation objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('r.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Reservation
    //    {
    //        return $this->createQueryBuilder('r')
    //            ->andWhere('r.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    //Requête SQL pour récupérer le nb total de réservation
    // public function findNbCouverts()
    // {
    //     $conn = $this->getEntityManager()->getConnection();
    //     $sql = 'SELECT SUM(nb_couverts) as nbCouverts FROM reservation';
    //     $stmt = $conn->prepare($sql);
    //     $resultSet = $stmt->executeQuery();
    //     // returns an array of arrays (i.e. a raw data set)
    //     return $resultSet->fetchAllAssociative();  
    // }

    //Requête SQL pour récupérer le nb total de réservation en fonction de la date et du service
    public function findNbCouverts($date, $service)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT SUM(nb_couverts) as nbCouverts FROM reservation WHERE date = :date AND service = :service';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('date', $date);
        $stmt->bindValue('service', $service);
        $resultSet = $stmt->executeQuery();
        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();  
    }

    /*
    //Requête utilisant le Query Builder pour récupérer le nb total de réservation en fonction de la date et du service (à tester)
    public function findNbCouverts($date, $service)
    {
        $qb = $this->createQueryBuilder('r')
            ->select('SUM(r.nbCouverts) as nbCouverts')
            ->where('r.date = :date')
            ->andWhere('r.service = :service')
            ->setParameter('date', $date)
            ->setParameter('service', $service);

        return $qb->getQuery()->getResult();
    }
    */

    /*
    //Requête DQL pour récupérer le nb total de réservation en fonction de la date et du service (à tester)
    public function findNbCouverts($date, $service)
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery('
            SELECT SUM(r.nbCouverts) as nbCouverts
            FROM App\Entity\Reservation r
            WHERE r.date = :date AND r.service = :service
        ');
        $query->setParameter('date', $date);
        $query->setParameter('service', $service);
        $result = $query->getSingleScalarResult();

        return $result;
    }
    */

    /*
    //Requête DQL
    public function findNbCouvertsTest()
    {
        return $this->getEntityManager()->createQuery(
            'SELECT SUM(nb_couverts) FROM reservation'
        )->getResult();
    }
    */
}