<?php
/**
 * Bootstrap Framework-а
 */

use DI\ContainerBuilder;
use Dotenv\Dotenv;

/**
 * Подключаем пакет PHPDotEnv
 * @see https://github.com/vlucas/phpdotenv
 */
$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

/**
 * Создадим и настроим контейнер.
 */
$containerBuilder = new ContainerBuilder();
$containerBuilder->enableCompilation(__DIR__);

/**
 * Добавим провайдеры через php-di definitions.
 */
$containerBuilder->addDefinitions(
    array_map(
        fn ($provider) => DI\factory([$provider, 'create']),
        config('providers')
    )
);

$container = $containerBuilder->build();

return $container;