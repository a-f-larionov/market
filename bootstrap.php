<?php

/**
 * Бутрстрап: загружаем необходимый функционал
 * 1 - определяем функцию app();
 * 2 - определяем функцию config();
 * 3 - подключаем компоненты.
 */

use App\Core\App;
use Dotenv\Dotenv;

/**
 * Singleton приложения-контейнера.
 * Тут мы можем получить доступ к компонентам из любой точки кода.
 * app()->get('containerName')->doSomething();
 * @return App
 * @see components.php
 */
function app()
{
    return App::getInstance();
}

/**
 * Подключаем пакет PHPDotEnv
 * @see https://github.com/vlucas/phpdotenv
 */
$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

/**
 * Простейшая версия конфигурации.
 * @param null|string $name
 * @return mixed|null|array
 */
function config(string $name = null)
{
    static $config;
    if (!$config) {
        $config = require __DIR__ . '/config.php';
    }
    if ($name) {
        return $config[$name] ?? null;
    } else {
        return $config;
    }
}

/**
 * Ниже мы подключаем компоненты фреймворка.
 * Все они будут доступны из любой точки кода, так:
 * app()->get('router')
 * и так:
 * app()->get(\Symfony\Routing\Router:class)
 */

/** @var array $components */
$components = config('components');

foreach ($components as $alias => $className) {
    /** @var object $instance */
    $instance = $className::getComponent();

    app()->set($alias, $instance);
    app()->set(get_class($instance), $instance);
}
