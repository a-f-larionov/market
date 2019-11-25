<?php

/**
 * Конфигурационный файл.
 * Многоуровневый массив.
 */

use App\Managers\Interfaces\GoodsManagerInterface;
use App\Managers\Interfaces\OrdersManagerInterface;
use App\Providers\EntityManagerProvider;
use App\Providers\GoodsManagerProvider;
use App\Providers\OrdersManagerProvider;
use App\Providers\RouterProvider;
use App\Providers\GoodsTestDataProviderProvider;
use App\TestDataProviders\Interfaces\GoodsTestDataProviderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;

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
     * Провайдеры сервисов\компонент приложения
     */
    'providers' => [
        RouterInterface::class => RouterProvider::class,
        EntityManagerInterface::class => EntityManagerProvider::class,

        GoodsTestDataProviderInterface::class => GoodsTestDataProviderProvider::class,

        OrdersManagerInterface::class => OrdersManagerProvider::class,
        GoodsManagerInterface::class => GoodsManagerProvider::class,
    ],
];