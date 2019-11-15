<?php

/**
 * Конфигурационный файл.
 * Многоуровневый массив.
 */

return [
    'entityManager' => [
        'driver' => 'pdo_mysql',
        'host' => 'localhost',
        'user' => 'market',
        'password' => 'market',
        'dbname' => 'market',
        'echoSQLLog' => false,
    ],

    /**
     * Компоненты приложения
     * Все они будут доступны из любой части кода так:
     * app()->get('router')
     * app()->get(\Symfony\Component\Routing\Router:class);
     */
    'components' => [
        'router' => \App\ComponentsProviders\RouterProvider::class,
        'entityManager' => \App\ComponentsProviders\EntityManagerProvider::class,
        'kernel' => \App\ComponentsProviders\KernelProvider::class,
        'request' => \App\ComponentsProviders\RequestProvider::class,

        'testGoodsProvider' => \App\ComponentsProviders\TestGoodsProvider::class,
    ],
];