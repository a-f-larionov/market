<?php

namespace App\Repositories;

use App\Models\Order;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class OrdersRepository
 * @package App\Repositories
 */
class OrdersRepository extends EntityRepository
{
    /**
     * OrdersRepository constructor.
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $class = $entityManager->getClassMetadata(Order::class);

        parent::__construct($entityManager, $class);
    }
}