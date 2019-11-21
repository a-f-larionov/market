<?php

namespace App\Core;

use DI\Container;
use DI\Definition\Source\MutableDefinitionSource;
use DI\Proxy\ProxyFactory;
use Psr\Container\ContainerInterface;

/**
 * Синглтон контейнера приложения.
 * @see http://php-di.org/
 * @see https://www.google.com/search?q=designt%20patterns%20singleton
 * Class App
 * @package App
 */
class App extends Container
{
    /**
     * Экземпляр приложения.
     * @var App
     */
    private static $instance;

    /**
     * Получить экземпляр приложения
     * @return self
     */
    static public function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    /**
     * Singleton шаблон ограничивает конструктор
     * App constructor.
     * @param MutableDefinitionSource|null $definitionSource
     * @param ProxyFactory|null $proxyFactory
     * @param ContainerInterface|null $wrapperContainer
     */
    private function __construct(
        MutableDefinitionSource $definitionSource = null,
        ProxyFactory $proxyFactory = null,
        ContainerInterface $wrapperContainer = null
    ) {
        parent::__construct($definitionSource, $proxyFactory, $wrapperContainer);
    }

    /**
     * Singleton шаблон ограничивает клонирование
     */
    private function __clone()
    {
    }

    /**
     * Singleton шаблон ограничивает десериализацию
     */
    private function __wakeup(): void
    {
    }

    /**
     * Singleton шаблон ограничивает сериализацию
     */
    private function __sleep(): void
    {
    }
}