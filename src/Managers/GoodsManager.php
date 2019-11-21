<?php

namespace App\Managers;

use App\Models\Good;
use Doctrine\ORM\EntityManager;

class GoodsManager
{
    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * GoodsManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Создание товара.
     * @param string $name название товара
     * @param float $price цена товара
     * @return Good
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(string $name, float $price): Good
    {
        $good = new Good();
        $good->setName($name);
        $good->setPrice($price);

        $this->entityManager->persist($good);
        $this->entityManager->flush();

        return $good;
    }
}