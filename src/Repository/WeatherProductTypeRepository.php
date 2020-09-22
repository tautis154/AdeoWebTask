<?php

namespace App\Repository;

use App\Entity\WeatherProductType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WeatherProductType|null find($id, $lockMode = null, $lockVersion = null)
 * @method WeatherProductType|null findOneBy(array $criteria, array $orderBy = null)
 * @method WeatherProductType[]    findAll()
 * @method WeatherProductType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WeatherProductTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WeatherProductType::class);
    }

    /**
     * @param $weather
     * @return WeatherProductType[] Returns an array of ProductWeatherCondition objects
     */

    public function findByWeatherType($weather)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.forecastName = :weather')
            ->setParameter('weather', $weather)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return WeatherProductType[] Returns an array of WeatherProductType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WeatherProductType
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
