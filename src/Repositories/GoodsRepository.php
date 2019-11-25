<?php

namespace App\Repositories;

use App\Models\Good;
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
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $class = $entityManager->getClassMetadata(Good::class);

        parent::__construct($entityManager, $class);
    }
}