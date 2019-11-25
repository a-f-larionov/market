<?php

namespace App\Repositories;

use App\Models\Order;
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
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $class = $entityManager->getClassMetadata(Order::class);

        parent::__construct($entityManager, $class);
    }
}