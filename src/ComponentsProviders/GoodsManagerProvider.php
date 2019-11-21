<?php

namespace App\ComponentsProviders;

use App\Core\AppComponentInterface;
use App\Managers\OrdersManager;

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
     */
    static public function getComponent(): OrdersManager
    {
        return app()->make(OrdersManager::class);
    }
}