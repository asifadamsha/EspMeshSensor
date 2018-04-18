<?php

namespace App\Repository;

use App\Entity\Data;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Data|null find($id, $lockMode = null, $lockVersion = null)
 * @method Data|null findOneBy(array $criteria, array $orderBy = null)
 * @method Data[]    findAll()
 * @method Data[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DataRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Data::class);
    }

    public function findDataSince($dateSince)
    {
        return $this->createQueryBuilder('data')
            ->andWhere('data.dateTime  >= :date_since')
            ->setParameter('date_since', $dateSince)

            ->addOrderBy('data.piece, data.capteur, data.dateTime', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDistinctDataPieceSince($dateSince)
    {
        return $this->createQueryBuilder('data')
            ->select('DISTINCT data.piece')
            ->andWhere('data.dateTime  >= :date_since')
            ->setParameter('date_since', $dateSince)

            ->addOrderBy('data.piece')
            ->getQuery()->getScalarResult()
            ;
    }

    public function getCountData()
    {
        return $this->createQueryBuilder('data')
            ->select('count(1)')
            ->getQuery()->getSingleScalarResult()
            ;
    }

    public function getCountDistinctPiece() {
        return $this->createQueryBuilder('data')
            ->select('COUNT(DISTINCT(data.piece))')
            ->getQuery()->getSingleScalarResult()
            ;
    }

    public function getCountDistinctCapteur() {
        return $this->createQueryBuilder('data')
            ->select('count(distinct(concat(data.piece, data.capteur)))')
            ->getQuery()->getSingleScalarResult()
            ;
    }

    public function findMinMaxAvgCapteurPiece($dateLastDay) {
        return $this->createQueryBuilder('data')
            ->select('data.piece, data.capteur, avg(data.valeur) as avg, max(data.valeur) as max, min(data.valeur) as min')
            ->addGroupBy('data.piece')
            ->addGroupBy('data.capteur')
            ->andWhere('data.dateTime  >= :date_since')
            ->setParameter('date_since', $dateLastDay)
            ->addOrderBy('data.piece, data.capteur', 'ASC')
            ->getQuery()->getScalarResult()
            ;
    }

}
