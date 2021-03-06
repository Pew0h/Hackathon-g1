<?php

namespace App\Repository;

use App\Entity\Campain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Campain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Campain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Campain[]    findAll()
 * @method Campain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CampainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Campain::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Campain $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Campain $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    public function getByDate(\Datetime $date)
    {
        $from = new \DateTime($date->format("Y-m-d") . " 00:00:00");

        $qb = $this->createQueryBuilder("e");
        $qb
            ->andWhere('e.startDate >= :from')
            ->orderBy("e.startDate")
            ->setParameter('from', $from);
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    public function findById($id)
    {
        $qb = $this->createQueryBuilder("e");
        $qb
            ->andWhere('e.id = :id')
            ->setParameter('id', $id);
        $result = $qb->getQuery()->getResult();

        return $result;
    }

    // /**
    //  * @return Campain[] Returns an array of Campain objects
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
    public function findOneBySomeField($value): ?Campain
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
