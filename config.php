<?php

/**
 * Конфигурационный файл.
 * Многоуровневый массив.
 */

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
        'router' => \App\ComponentsProviders\RouterProvider::class,
        'entityManager' => \App\ComponentsProviders\EntityManagerProvider::class,
        'kernel' => \App\ComponentsProviders\KernelProvider::class,
        'request' => \App\ComponentsProviders\RequestProvider::class,

        'testGoodsProvider' => \App\ComponentsProviders\TestGoodsProvider::class,
        'ordersManager' => \App\ComponentsProviders\OrdersManagerProvider::class,
        'yandexClient' => \App\ComponentsProviders\YandexClientAPIProvider::class,
    ],
];