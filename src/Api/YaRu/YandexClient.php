<?php

namespace App\Api\YaRu;

/**
 * Клиент платежной системы YaRu.
 * Это псевдосистема, если https://ya.ru ответил 200 - платеж считается проведенным.
 * Class Client
 * @package App\Api\YaRu
 */
class YandexClient
{
    /**
     * URL запроса проверки платежа.
     */
    private const URL_FOR_CHECK_ORDER_PAYED = 'https://ya.ru';

    /**
     * Проверяет оплачен ли заказ.
     * @param int $orderId id заказа
     * @param float $sum сумма заказа
     * @return bool true - оплачен, false - не оплачен.
     */
    public function checkPayed(int $orderId, float $sum): bool
    {
        $client = new \GuzzleHttp\Client();

        $query = \GuzzleHttp\Psr7\build_query([
            'orderId' => $orderId,
            'summ' => $sum
        ]);

        $uri = self::URL_FOR_CHECK_ORDER_PAYED . '/?' . $query;

        $response = $client->request('get', $uri);

        return $response->getStatusCode() === 200;
    }
}