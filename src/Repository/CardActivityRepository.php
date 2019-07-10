<?php


namespace App\Repository;


use App\Entity\CardActivity;
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



}