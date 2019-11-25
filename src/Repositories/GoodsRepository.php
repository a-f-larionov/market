<?php

namespace App\Repositories;

use App\Models\Good;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Class GoodsRepository
 * @package App\Repositories
 */
class GoodsRepository extends EntityRepository
{
    /**
     * GoodsRepository constructor.
     * @throws DependencyException
     * @throws NotFoundException
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $class = $entityManager->getClassMetadata(Good::class);

        parent::__construct($entityManager, $class);
    }
}