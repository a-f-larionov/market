<?php

namespace App\Api\Yandex;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use function GuzzleHttp\Psr7\build_query;

/**
 * Class YandexClientAPI
 * Клиент платежной системы Yandex.
 * Это псевдосистема, если https://ya.ru ответил 200 - платеж считается проведенным.
 * @package App\Api\Yandex
 */
class  YandexClientAPI
{
    /**
     * @var Client
     */
    private Client $httpClient;

    /**
     * URL запроса проверки платежа.
     */
    private const URL_FOR_CHECK_ORDER_PAYED = 'https://ya.ru';

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }


    /**
     * Проверяет оплачен ли заказ.
     * @param int $orderId id заказа
     * @param float $sum сумма заказа
     * @return bool true - оплачен, false - не оплачен.
     * @throws GuzzleException
     */
    public function checkPayed(int $orderId, float $sum): bool
    {
        $query = build_query([
            'orderId' => $orderId,
            'sum' => $sum
        ]);

        $uri = self::URL_FOR_CHECK_ORDER_PAYED . '/?' . $query;

        $response = $this->httpClient->request('get', $uri);

        return $response->getStatusCode() === 200;
    }

}