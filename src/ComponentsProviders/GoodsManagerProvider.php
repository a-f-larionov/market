<?php

namespace App\ComponentsProviders;

use App\Core\AppComponentInterface;
use App\Managers\GoodsManager;

/**
 * Создает компонент менеджер заказов.
 * Class GoodsManagerProvider
 * @package App\Components
 */
class GoodsManagerProvider implements AppComponentInterface
{
    /**
     * Создает компонент менеджер заказов.
     * @return GoodsManager
     */
    static public function getComponent(): GoodsManager
    {
        return app()->make(GoodsManager::class);
    }
}