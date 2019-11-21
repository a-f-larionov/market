<?php

namespace App\ComponentsProviders;

use App\Core\AppComponentInterface;
use App\Managers\GoodsManager;
use DI\DependencyException;
use DI\NotFoundException;

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
     * @throws DependencyException
     * @throws NotFoundException
     */
    static public function getComponent(): GoodsManager
    {
        return app()->make(GoodsManager::class);
    }
}