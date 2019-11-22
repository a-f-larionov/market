<?php

namespace App\Repositories;

use App\Models\Good;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

/**
 * Class GoodsRepository
 * @package App\Repositories
 */
class GoodsRepository extends EntityRepository
{

    public function __construct()
    {
        /** @var EntityManager $em */
        $em = app()->get('entityManager');
        $class = $em->getClassMetadata(Good::class);

        parent::__construct($em, $class);
    }
}