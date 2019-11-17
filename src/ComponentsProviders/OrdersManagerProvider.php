<?php

namespace App\ComponentsProviders;

use App\Managers\OrdersManager;

/**
 * Создает компонент менеджер заказов.
 * Class OrdersManagerProvider
 * @package App\Components
 */
class OrdersManagerProvider implements ComponentInterface
{
    /**
     * Создает компонент менеджер заказов.
     * @return OrdersManager
     */
    static public function getComponent(): OrdersManager
    {
        return new OrdersManager();
    }
}