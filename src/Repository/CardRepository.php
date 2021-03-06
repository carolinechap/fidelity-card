<?php

namespace App\Repository;

use App\Entity\Card;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{

    /**
     * CardRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Card::class);
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function findCardByUser(User $user)
    {
        $qb = $this->createQueryBuilder('c')
            ->join('c.user', 'cu')
            ->andWhere('c.user = :user')
            ->setParameter(':user', $user);

        return $qb->getQuery()->getResult();
    }

    /**
     * @return Query
     */
    public function findCardByOrderStore(): Query
    {
        $qb = $this->createQueryBuilder('c');
        $qb->orderBy('c.store', 'DESC')
            ->join('c.store', 'cs')
            ->orderBy('cs.name', 'ASC');
        $query = $qb->getQuery();
        return $query;
    }

    /**
     * @return mixed
     */
    public function findLastRecord()
    {
        $qb = $this->createQueryBuilder('c');
        $qb->orderBy('c.id', 'DESC')
            ->setMaxResults(1);
        $query = $qb->getQuery()->getResult();
        return $query;


    }

    /**
     * @return mixed
     */
    public function findCardWithUser(){
        $qb = $this->createQueryBuilder('c')
            ->join('c.user', 'cu')
            ->andWhere('c.user is not NULL');

        return $qb->getQuery()->getResult();
    }





    // /**
    //  * @return Card[] Returns an array of Card objects
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
    public function findOneBySomeField($value): ?Card
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
