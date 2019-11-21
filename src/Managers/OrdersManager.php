<?php
namespace App\Managers;

use App\Models\Good;
use App\Models\Order;
use App\Models\OrderItem;
use Doctrine\ORM\EntityManager;

/**
 * Менеджер заказов.
 * Class OrdersManager
 * @package App\Managers
 */
class OrdersManager
{
    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * OrdersManager constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Создать заказ.
     * @param array $goodIds id товаров
     * @return Order
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createOrder(array $goodIds): Order
    {
        $order = new Order();
        // запишем заказ в БД, что бы получить id заказа.
        $this->entityManager->persist($order);
        $this->entityManager->flush();

        $goodsRepository = $this->entityManager->getRepository(Good::class);
        /** @var Good[] $goods */
        $goods = $goodsRepository->findById($goodIds);

        // создадим позиции заказа
        foreach ($goods as $good) {
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setGood($good);
            $this->entityManager->persist($orderItem);
        }

        return $order;
    }
}