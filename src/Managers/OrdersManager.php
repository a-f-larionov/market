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
     * Создать заказ.
     * @param array $goodIds id товаров
     * @return Order
     */
    public function createOrder(array $goodIds): Order
    {
        /** @var EntityManager $entityManager */
        $entityManager = app()->get('entityManager');

        $order = new Order();
        // запишем заказ в БД, что бы получить id заказа.
        $entityManager->persist($order);
        $entityManager->flush();

        $goodsRepository = $entityManager->getRepository(Good::class);
        /** @var Good[] $goods */
        $goods = $goodsRepository->findById($goodIds);

        // создадим позиции заказа
        foreach ($goods as $good) {
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setGood($good);
            $entityManager->persist($orderItem);
        }

        return $order;
    }
}