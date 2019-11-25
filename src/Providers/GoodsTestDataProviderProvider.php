<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\TestDataProviders\GoodsTestDataProvider;
use Psr\Container\ContainerInterface;

/**
 * Компонент предоставления тестовых данных для товаров.
 * Class KernelProvider
 * @package App\Components
 */
class GoodsTestDataProviderProvider implements ProviderInterface
{
    /**
     * Создает сам себя(провайдер тестовых данных товаров).
     * @return GoodsTestDataProviderProvider
     */
    static public function create(ContainerInterface $container): GoodsTestDataProvider
    {
        return $container->make(GoodsTestDataProvider::class);
    }
}
