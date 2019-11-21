<?php

/**
 * Конфигурационный файл.
 * Многоуровневый массив.
 */

use App\ComponentsProviders\EntityManagerProvider;
use App\ComponentsProviders\GoodsManagerProvider;
use App\ComponentsProviders\KernelProvider;
use App\ComponentsProviders\OrdersManagerProvider;
use App\ComponentsProviders\RequestProvider;
use App\ComponentsProviders\RouterProvider;
use App\ComponentsProviders\TestGoodsProvider;
use App\ComponentsProviders\YandexClientAPIProvider;

return [
    'entityManager' => [
        'driver' => 'pdo_mysql',
        'host' => getenv('DB_HOST', 'localhost'),
        'user' => getenv('DB_USER'),
        'password' => getenv('DB_PASSWORD'),
        'dbname' => getenv('DB_NAME'),
        'echoSQLLog' => getenv('ECHO_SQL_LOG', false),
    ],

    /**
     * Компоненты приложения
     * Все они будут доступны из любой части кода так:
     * app()->get('router')
     * app()->get(\Symfony\Component\Routing\Router:class);
     * Классы в значении массива, должны реализовать интерфейс ComponentInterface
     */
    'components' => [
        'router' => RouterProvider::class,
        'entityManager' => EntityManagerProvider::class,
        'kernel' => KernelProvider::class,
        'request' => RequestProvider::class,

        'testGoodsProvider' => TestGoodsProvider::class,
        'ordersManager' => OrdersManagerProvider::class,
        'goodsManager' => GoodsManagerProvider::class,

        'yandexClient' => YandexClientAPIProvider::class,
    ],
];