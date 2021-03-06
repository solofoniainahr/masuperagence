<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Property>
 *
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function add(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Property $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * 
     *
     * @return Property []
     */
    public function findAllVisible(PropertySearch $search): Query
    {
        //dd($search->getOptions());
        $query = $this->findVisibleQuery();
        if ( $search->getMaxPrice() ) {
            $query = $query->where('p.price < :maxPrice')
            ->setParameter('maxPrice', $search->getMaxPrice());
        }
        if ( $search->getMinSurface() ) {
            $query = $query->andWhere('p.surface > :minSurface')
            ->setParameter('minSurface', $search->getMinSurface());
        }
        if( count($search->getOptions()) > 0 )
        {
            $k = 0;
            //foreach ($search->getOptions() as $k => $option) {
            foreach ($search->getOptions() as $option) {//On enleve le $k(index) pour eviter le mal intention de l"user sur l'url
                $k ++;
                $query = $query->andWhere(":option$k MEMBER OF p.options")//POur  la relation ManyToMany
                //$query = $query->andWhere('p.options IN (:options)')
                               //->setParameter("options", $search->getOptions());
                               ->setParameter("option$k", $option);
            }
        }


        return $query->getQuery();
        //->getResult();
    }

    /**
     * 
     *
     * @return Property []
     */
    public function findLatest(): array
    {

        $properties = $this->findVisibleQuery()
                           ->setMaxResults(4)
                           ->getQuery()
                           ->getResult();

        return $properties;
    }

    public function findVisibleQuery(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
                           ->where('p.sold = false');
    }


//    /**
//     * @return Property[] Returns an array of Property objects
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

//    public function findOneBySomeField($value): ?Property
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
