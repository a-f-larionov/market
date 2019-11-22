<?php

namespace App\Managers;

use App\Models\Good;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\GoodsRepository;
use Doctrine\ORM\EntityManager;
use Throwable;
use App\Exceptions\UserRequestErrorException;

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
     * @var GoodsRepository
     */
    private GoodsRepository $goodsRepository;

    /**
     * OrdersManager constructor.
     * @param EntityManager $entityManager
     * @param GoodsRepository $goodsRepository
     */
    public function __construct(EntityManager $entityManager, GoodsRepository $goodsRepository)
    {
        $this->goodsRepository = $goodsRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * Создать заказ.
     * @param array $goodIds id товаров
     * @return Order
     * @throws Throwable
     */
    public function createOrder(array $goodIds): Order
    {
        $this->entityManager->beginTransaction();

        try {
            $order = new Order();
            // запишем заказ в БД, что бы получить id заказа.
            $this->entityManager->persist($order);
            $this->entityManager->flush();

            /** @var Good[] $goods */
            $goods = $this->goodsRepository->findById($goodIds);

            /** @var int[] id товаров существующих в БД $foundIds */
            $foundIds = array_map(fn (Good $good): int => $good->getId(), $goods);

            /** @var int[] id товаров, которые запрашивали но в бд не найдены $notFoundIds */
            $notFoundIds = array_diff($goodIds, $foundIds);

            if (count($notFoundIds) > 0) {
                throw new UserRequestErrorException(
                    "Запрашиваемые товары с ids = `" . join(',',
                        $notFoundIds) . "` не найдены."
                );
            }

            // создадим позиции заказа
            foreach ($goods as $good) {
                $orderItem = new OrderItem();
                $orderItem->setOrder($order);
                $orderItem->setGood($good);
                $this->entityManager->persist($orderItem);
            }

            $this->entityManager->flush();
            $this->entityManager->commit();

        } catch (Throwable $throwable) {

            $this->entityManager->rollback();
            throw $throwable;
        }

        return $order;
    }
}