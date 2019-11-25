<?php

namespace App\Providers;

use App\Providers\Interfaces\ProviderInterface;
use App\Api\YaRu\YandexClientApi;
use Psr\Container\ContainerInterface;


/**
 * Провайдер YandexClientAPI
 * Class YandexClientAPIProvider
 * @package App\Providers
 */
class YandexClientAPIProvider implements ProviderInterface
{
    /**
     * Создает YandexClientApi.
     */
    static public function create(ContainerInterface $container): YandexClientApi
    {
        return $container->make(YandexClientApi::class);
    }
}