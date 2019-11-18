<?php

namespace App\Core;

/**
 * Интерфейс компонента
 * Interface ComponentInterface
 * @package App\Components
 */
interface AppComponentInterface
{
    /**
     * Возвращает инстанс компонента.
     * @return mixed
     */
    static public function getComponent();
}