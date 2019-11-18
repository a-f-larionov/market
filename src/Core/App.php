<?php

namespace App\Core;

/**
 * Синглтон контейнера приложения.
 * @see http://php-di.org/
 * @see https://www.google.com/search?q=designt%20patterns%20singleton
 * Class App
 * @package App
 */
class App extends \DI\Container
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
     * @param \DI\Definition\Source\MutableDefinitionSource|null $definitionSource
     * @param \DI\Proxy\ProxyFactory|null $proxyFactory
     * @param \Psr\Container\ContainerInterface|null $wrapperContainer
     */
    private function __construct(
        \DI\Definition\Source\MutableDefinitionSource $definitionSource = null,
        \DI\Proxy\ProxyFactory $proxyFactory = null,
        \Psr\Container\ContainerInterface $wrapperContainer = null
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