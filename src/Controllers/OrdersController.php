<?php

namespace App\Controllers;

use App\Api\YaRu\YandexClient;
use App\Managers\OrdersManager;
use App\Models\Good;
use App\Models\Order;
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
    public function create(Request $request, EntityManager $entityManager, OrdersManager $ordersManager): Response
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
        $order = $ordersManager->createOrder($foundIds);

        $entityManager->flush();

        $entityManager->commit();

        return $this->responseJSON($order->mapToArray());
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
        if (!$orderId) {
            return $this->responseWithFailed("Нужно передать `id`");
        }

        /** @var Order $order Заказ */
        $order = $entityManager->find(Order::class, $orderId);

        if (!$order) {
            return $this->responseWithFailed("Нет заказа с `id`=`{$orderId}`");
        }

        if (!$order->isNew()) {
            return $this->responseWithFailed("Заказ не в статусе Новый. Нельзя оплатить.");
        }

        if (!$order->getOrderItems()->count()) {
            return $this->responseWithFailed("Заказ пуст.");
        }
        // в сравении цен, используем технику epsilon, т.к. у нас float
        // @see https://www.php.net/manual/en/language.types.float.php#language.types.float.comparison
        $epsilon = 0.00001;
        if (abs($sum - $order->calculateSumm()) > $epsilon) {
            return $this->responseWithFailed("Сумма не соответвует. Ожидалось: `{$order->calculateSumm()}`, передано: {$sum}");
        }

        $client = new YandexClient();

        if (!$client->checkPayed($orderId, $sum)) {
            return $this->responseWithFailed("YaRu отказал в проведении платежа. Попробуйте позже.");
        }

        $order->setStatusPayed();

        $entityManager->flush();

        return $this->responseWithSuccess("Оплачено");
    }
}