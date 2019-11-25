<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\Managers\GoodsManager;
use Psr\Container\ContainerInterface;

/**
 * Создает компонент менеджер заказов.
 * Class GoodsManagerProvider
 * @package App\Components
 */
class GoodsManagerProvider implements ProviderInterface
{
    /**
     * Создает компонент менеджер заказов.
     * @param ContainerInterface $container
     * @return GoodsManager
     */
    static public function create(ContainerInterface $container): GoodsManager
    {
        return $container->make(GoodsManager::class);
    }
}