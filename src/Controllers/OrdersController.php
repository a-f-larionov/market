<?php

namespace App\Controllers;

use App\Api\YaRu\Client;
use App\Models\Good;
use App\Models\Order;
use App\Models\OrderItem;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Контроллер заказов.
 * Class OrdersController
 * @package App\Controllers
 */
class OrdersController extends BaseController
{
    /**
     * Создает заказ
     * @param Request $request
     * @param EntityManager $entityManager
     * @return Response
     */
    public function create(Request $request, EntityManager $entityManager): Response
    {
        /** @var int[] id запрашиваемых товаров $requestIds */
        $requestIds = $request->get('ids');

        // далее идет код валидации запроса
        if (!$requestIds || !is_string($requestIds)) {
            return $this->responseWithFailed("Параметр `ids` нужно передать.");
        }

        // получим массив только чисел.
        $requestIds = explode(',', $requestIds);
        $requestIds = array_filter($requestIds, "intval");
        $requestIds = array_unique($requestIds);

        if (!is_array($requestIds) || count($requestIds) == 0) {
            return $this->responseWithFailed("Параметр `ids` нужно передать.");
        }

        $entityManager->beginTransaction();

        $goodsRepository = $entityManager->getRepository(Good::class);
        /** @var Good[] $goods */
        $goods = $goodsRepository->findById($requestIds);

        /** @var int[] id товаров существующих в БД $foundIds */
        $foundIds = array_map(function (Good $good) {
            return $good->getId();
        }, $goods);

        /** @var int[] id товаров, которые запрашивали но в бд не найдены $notFoundIds */
        $notFoundIds = array_diff($requestIds, $foundIds);

        if (count($notFoundIds) > 0) {
            return $this->responseWithFailed("Запрашиваемые товары с ids = `" . join(',',
                    $notFoundIds) . "` не найдены.");
        }

        // валидация пройдена, можно создавать заказ.
        $order = $this->createOrder($goods, $entityManager);

        $entityManager->flush();

        $entityManager->commit();

        return $this->responseJSON($order->mapToArray());
    }

    /**
     * Создать заказ.
     * @param array $goods
     * @param EntityManager $entityManager
     * @return Order
     */
    private function createOrder(array $goods, EntityManager $entityManager): Order
    {
        $order = new Order();
        // запишем заказ в БД, что бы получить id заказа.
        $entityManager->persist($order);
        $entityManager->flush();

        // создадим позиции заказа
        foreach ($goods as $good) {
            $orderItem = new OrderItem();
            $orderItem->setOrder($order);
            $orderItem->setGood($good);
            $entityManager->persist($orderItem);
        }

        return $order;
    }

    /**
     * Произвести оплату заказа
     * @param int $orderId id заказа
     * @param float $sum сумма, должна соответствоать сумме заказа.
     * @param EntityManager $entityManager
     * @return Response
     */
    public function pay(int $orderId, float $sum, EntityManager $entityManager): Response
    {
        /** @var Order $order Заказ */
        $order = $entityManager->find(Order::class, $orderId);

        if (!$orderId) {
            return $this->responseWithFailed("Нужно передать `id`");
        }

        if (!$order) {
            return $this->responseWithFailed("Нет заказа с `id`=`{$orderId}`");
        }

        if (!$order->isNew()) {
            return $this->responseWithFailed("Заказ не в статусе Новый. Нельзя оплатить.");
        }

        if (!$order->getOrderItems()->count()) {
            return $this->responseWithFailed("Заказ пуст.");
        }

        if ((float)$sum !== $order->calculateSumm()) {
            return $this->responseWithFailed("Сумма не соответвует. Ожидалось: `{$order->calculateSumm()}`, передано: {$sum}");
        }

        $client = new Client();

        if (!$client->checkPayed($orderId, $sum)) {
            return $this->responseWithFailed("YaRu отказал в проведении платежа. Попробуйте позже.");
        }

        $order->setStatusPayed();

        $entityManager->flush();

        return $this->responseWithSuccess("Оплачено");
    }
}