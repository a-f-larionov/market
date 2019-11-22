<?php

namespace App\Repositories;

use App\Models\Order;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\EntityManager;
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
    public function __construct()
    {
        /** @var EntityManager $em */
        $em = app()->get('entityManager');
        $class = $em->getClassMetadata(Order::class);

        parent::__construct($em, $class);
    }
}