<?php

namespace App\Providers\Interfaces;

use Psr\Container\ContainerInterface;

/**
 * Интерфейс компонента
 * Interface ComponentInterface
 * @package App\Components
 */
interface ProviderInterface
{
    /**
     * Возвращает инстанс компонента.
     * @param ContainerInterface $container
     * @return mixed
     */
    static public function create(ContainerInterface $container);
}