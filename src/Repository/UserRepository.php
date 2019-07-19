<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function searchByRoles($roles = []) : Query
    {
        $roles = serialize($roles);

        $qb = $this->createQueryBuilder('u');
        $qb->orderBy('u.lastname', 'ASC');
        $qb->andWhere('u.roles = :roles')
            ->setParameter(':roles', $roles);
        $query = $qb->getQuery();
        return $query;
    }

    public function findLastRecordByRole($roles = [])
    {
        $roles = serialize($roles);

        $qb = $this->createQueryBuilder('u');
        $qb->orderBy('u.id', 'DESC')
            ->andWhere('u.roles = :roles')
            ->setParameter(':roles', $roles)
            ->setMaxResults(1);
        $query = $qb->getQuery()->getResult();
        return $query;
    }

    public function getCustomersByStore($store)
    {
        $roles = ['ROLE_USER'];
        $roles = serialize($roles);

        $qb = $this->createQueryBuilder('u');
        $qb
            ->andWhere('u.roles = :roles')
            ->join('u.stores', 'ust')
            ->orderBy('ust.id', 'DESC')
            ->andWhere('ust.id = :storeId')
            ->setParameter(':roles', $roles)
            ->setParameter(':storeId', $store);

        return $qb;
    }


    public function searchUser($roles = [], array $filters = []) : Query
    {
        $roles = serialize($roles);

        $qb = $this->createQueryBuilder('u');
        $qb->orderBy('u.lastname', 'ASC');

        if (!empty($filters['lastname'])){
            $qb->andWhere('u.lastname LIKE :lastname')
                ->setParameter(':lastname', '%' . $filters['lastname'] . '%');
        }
        if (!empty($filters['firstname'])){
            $qb->andWhere('u.firstname LIKE :firstname')
                ->setParameter(':firstname', '%' . $filters['firstname'] . '%');
        }
        if (!empty($filters['email'])){
            $qb->andWhere('u.email LIKE :email')
                ->setParameter(':email', '%' . $filters['email'] . '%');
        }

        $qb->andWhere('u.roles = :roles')
            ->setParameter(':roles', $roles);

        $query = $qb->getQuery();
        return $query;
    }




    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
