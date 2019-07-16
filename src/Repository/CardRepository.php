<?php

namespace App\Repository;

use App\Entity\Card;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Paginator;
use Doctrine\ORM\Tools\Pagination\Paginator as DoctrinePaginator;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
/**
 * @method Card|null find($id, $lockMode = null, $lockVersion = null)
 * @method Card|null findOneBy(array $criteria, array $orderBy = null)
 * @method Card[]    findAll()
 * @method Card[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardRepository extends ServiceEntityRepository
{

    private $user;

    private $tokenStorage;

    const ITEMS_PER_PAGE = 5;

    public function __construct(RegistryInterface $registry, TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
        parent::__construct($registry, Card::class);
    }

    public function findCardByUser(User $user){
        $qb = $this->createQueryBuilder('c')
            ->join('c.user', 'cu')
            ->andWhere('c.user = :user')
            ->setParameter(':user', $user);

        return $qb->getQuery()->getResult();
    }

    public function findCardByOrderStore(): Query
    {
        $qb = $this->createQueryBuilder('c');
        $qb->orderBy('c.store', 'DESC')
            ->join('c.store', 'cs')
            ->orderBy('cs.name', 'ASC');
        $query = $qb->getQuery();
        return $query;
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
