<?php

namespace App\ComponentsProviders;

use App\Core\AppComponentInterface;
use App\Managers\OrdersManager;
use DI\DependencyException;
use DI\NotFoundException;

/**
 * Создает компонент менеджер заказов.
 * Class OrdersManagerProvider
 * @package App\Components
 */
class OrdersManagerProvider implements AppComponentInterface
{
    /**
     * Создает компонент менеджер заказов.
     * @return OrdersManager
     * @throws DependencyException
     * @throws NotFoundException
     */
    static public function getComponent(): OrdersManager
    {
        return app()->make(OrdersManager::class);
    }
}