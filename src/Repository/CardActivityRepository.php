<?php


namespace App\Repository;


use App\Entity\CardActivity;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CardActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method CardActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method CardActivity[]    findAll()
 * @method CardActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CardActivityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CardActivity::class);
    }


    public function findActivityByUser(User $user)
    {
        $qb = $this->createQueryBuilder('ca');
        $qb->join('ca.activity', 'caa')
            ->join('ca.card', 'cac')
            ->andWhere('cac.user = :user')
            ->setParameter(':user', $user);

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


}