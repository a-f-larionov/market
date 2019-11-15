<?php

namespace App\ComponentsProviders;

/**
 * Интерфейс компонента
 * Interface ComponentInterface
 * @package App\Components
 */
interface ComponentInterface
{
    /**
     * Возвращает инстанс компонента.
     * @return mixed
     */
    static public function getComponent();
}