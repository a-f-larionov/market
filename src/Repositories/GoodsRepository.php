<?php

namespace App\Repositories;

use App\Models\Good;
use DI\DependencyException;
use DI\NotFoundException;
use Doctrine\ORM\EntityManager;
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
    public function __construct()
    {
        /** @var EntityManager $em */
        $em = app()->get('entityManager');
        $class = $em->getClassMetadata(Good::class);

        parent::__construct($em, $class);
    }
}