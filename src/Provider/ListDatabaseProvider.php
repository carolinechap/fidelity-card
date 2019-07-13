<?php


namespace App\Provider;

use Symfony\Bridge\Doctrine\RegistryInterface;

class ListDatabaseProvider
{
    private $registry;

    public function __construct(RegistryInterface $registry)
    {
        $this->registry = $registry;
    }

    public function getListForClass($className)
    {
        $repository = $this->registry->getRepository($className);

        return $repository->findAll();
    }

}