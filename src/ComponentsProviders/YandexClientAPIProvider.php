<?php

namespace App\ComponentsProviders;

use App\Api\YaRu\YandexClientApi;
use App\Core\AppComponentInterface;

/**
 * Провайдер YandexClientAPI
 * Class YandexClientAPIProvider
 * @package App\ComponentsProviders
 */
class YandexClientAPIProvider implements AppComponentInterface
{
    /**
     * Создает YandexClientApi.
     */
    static public function getComponent():YandexClientApi
    {
        return app()->make(YandexClientApi::class);
    }
}