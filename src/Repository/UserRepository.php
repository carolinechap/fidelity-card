<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param array $roles
     * @return QueryBuilder
     */
    public function searchByRolesQb($roles = []) : QueryBuilder
    {
        $roles = serialize($roles);

        $qb = $this->createQueryBuilder('u');
        $qb->orderBy('u.lastname', 'ASC');
        $qb->andWhere('u.roles = :roles')
            ->setParameter(':roles', $roles);

        return $qb;
    }

    public function searchByRoles($roles = []): Query
    {
        $qb = $this->searchByRolesQb();
        $query = $qb->getQuery();

        return $query;
    }

    /**
     * @param array $roles
     * @return mixed
     */
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

    /**
     * @param array $roles
     * @param array $filters
     * @return Query
     */
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

    /**
     * @param User $user
     * @return mixed
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findStoreForEmployee(User $user)
    {
        $roles = serialize(['ROLE_ADMIN']);

        $qb = $this->createQueryBuilder('e');

        $qb
            ->andWhere('e.roles = :roles')
            ->andWhere('e.id = :user')
            ->join('e.stores', 'ust')
            ->setParameter(':user', $user)
            ->setParameter(':roles', $roles)
            ;

        return $qb->getQuery()->getOneOrNullResult();
    }


    public function findByEmail($email){
        $qb = $this->createQueryBuilder('u');
        $qb->andWhere('u.email = :email')
            ->setParameter(':email', $email);

        return $qb->getQuery()->getResult();
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
