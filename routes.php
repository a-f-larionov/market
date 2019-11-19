<?php

use \App\Controllers\GoodsController;
use \App\Controllers\OrdersController;

/**
 * В этом файле описаны роутинги.
 * @see https://symfony.com/doc/current/components/routing.html
 */
return function (\Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator $routes) {

    $routes->add('/goods/create-test-pack', '/goods/create-test-pack')
        ->controller([GoodsController::class, 'createTestPack']);

    $routes->add('/goods/list-all', '/goods/list-all/{page}')
        ->controller([GoodsController::class, 'listAll']);

    // это должен быть POST, для ручного тестирования используем GET
    $routes->add('/orders/create', '/orders/create')
        ->controller([OrdersController::class, 'create'])
        ->methods(['GET']);

    // это должен быть POST, для ручного тестирования используем GET
    $routes->add('/orders/pay', '/orders/pay/{orderId}/{sum}')
        ->controller([OrdersController::class, 'pay'])
        ->methods(['GET']);
};