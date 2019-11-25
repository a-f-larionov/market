<?php

namespace App\Controllers;

use App\Api\Yandex\YandexClientAPI;
use App\Exceptions\UserRequestErrorException;
use App\Managers\Interfaces\OrdersManagerInterface;
use App\Managers\OrdersManager;
use App\Models\Order;
use Doctrine\DBAL\LockMode;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\PessimisticLockException;
use Doctrine\ORM\TransactionRequiredException;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

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
     * @param OrdersManager $ordersManager
     * @return Response
     * @throws Throwable
     */
    public function create(Request $request, OrdersManagerInterface $ordersManager): Response
    {
        /** @var int[] id запрашиваемых товаров $requestIds */
        $goodIds = $request->get('ids');

        // далее идет код валидации запроса
        if (!$goodIds || !is_string($goodIds)) {
            return $this->responseWithFailed("Параметр `ids` нужно передать.");
        }

        // получим массив только чисел.
        $goodIds = array_reduce(
            explode(',', $goodIds),
            function ($carry, $item) {
                if (ctype_digit($item)) {
                    $carry[] = (int)$item;
                }
                return $carry;
            },
            []
        );

        if (!is_array($goodIds) || count($goodIds) == 0) {
            return $this->responseWithFailed("Параметр `ids` нужно передать.");
        }

        // валидация пройдена, можно создавать заказ.
        $order = $ordersManager->createOrder($goodIds);

        return $this->responseJSON($order->mapToArray());
    }

    /**
     * Произвести оплату заказа
     * @param int $orderId id заказа
     * @param float $sum сумма, должна соответствоать сумме заказа.
     * @param EntityManager $entityManager
     * @param YandexClientApi $yandexClient
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws TransactionRequiredException
     * @throws GuzzleException
     * @throws UserRequestErrorException
     */
    public function pay(int $orderId, float $sum, EntityManagerInterface $entityManager, YandexClientAPI $api): Response
    {
        if ($orderId < 1) {
            return $this->responseWithFailed("Нужно передать `id`");
        }

        try {
            $entityManager->beginTransaction();

            /** @var Order $order Заказ */
            $order = $entityManager->find(Order::class, $orderId, LockMode::PESSIMISTIC_WRITE);

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
            if (abs($sum - $order->calculateSum()) > $epsilon) {
                return $this->responseWithFailed("Сумма не соответвует. Ожидалось: `{$order->calculateSum()}`, передано: {$sum}");
            }

            if (!$api->checkPayed($orderId, $sum)) {
                return $this->responseWithFailed("Yandex отказал в проведении платежа. Попробуйте позже.");
            }

            $order->setStatusPayed();

            $entityManager->flush();

            $entityManager->commit();

        } catch (PessimisticLockException $e) {

            $entityManager->rollback();
            throw new UserRequestErrorException("Кто то уже начал оплату этого заказа.");
        }

        return $this->responseWithSuccess("Оплачено");
    }
}