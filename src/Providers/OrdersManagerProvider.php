<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\Managers\OrdersManager;
use Psr\Container\ContainerInterface;

/**
 * Создает компонент менеджер заказов.
 * Class OrdersManagerProvider
 * @package App\Components
 */
class OrdersManagerProvider implements ProviderInterface
{
    /**
     * Создает компонент менеджер заказов.
     * @param ContainerInterface $container
     * @return OrdersManager
     */
    static public function create(ContainerInterface $container): OrdersManager
    {
        return $container->make(OrdersManager::class);
    }
}